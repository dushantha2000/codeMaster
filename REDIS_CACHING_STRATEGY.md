# Redis Caching Strategy for CodeMaster

## Current State Analysis

**Current Cache Driver:** Database (`CACHE_STORE=database`)  
**Redis Status:** Configured but not actively used  
**Key Performance Bottlenecks Identified:**

1. **Dashboard Queries** - Complex queries with partnerships, relationships, and pagination
2. **Partnership Lookups** - Frequently queried on every dashboard load
3. **Search Results** - Full-text search without caching
4. **Language Lists** - Aggregated queries run on every page load
5. **User Profile Data** - Partnership joins without caching
6. **Snippet Listings** - Eager loading relationships on every request

---

## Recommended Redis Caching Strategies

### 1. **Query Result Caching** (High Priority)
Cache expensive database queries with user-specific keys and appropriate TTLs.

**Best For:**
- Dashboard snippet listings
- Partnership data
- User-specific queries
- Language aggregations

**TTL Recommendations:**
- User-specific data: 5-15 minutes
- Shared/public data: 30-60 minutes
- Static lists: 1-4 hours

### 2. **Cache Tags** (High Priority)
Use Laravel cache tags for efficient invalidation when related data changes.

**Best For:**
- Snippet-related caches (invalidate when snippets change)
- User-related caches (invalidate when user data changes)
- Partnership caches (invalidate when partnerships change)

### 3. **Cache-Aside Pattern** (Standard)
Check cache first, fallback to database, then store result in cache.

**Best For:**
- All read-heavy operations
- Dashboard listings
- Search results

### 4. **Write-Through Caching** (Medium Priority)
Update cache immediately when data changes.

**Best For:**
- Snippet CRUD operations
- Partnership updates
- User profile updates

### 5. **Partial Caching** (Low Priority)
Cache only frequently accessed parts of complex queries.

**Best For:**
- Partnership IDs (cache separately from full snippet queries)
- User names (cache separately from full user objects)

---

## Implementation Priority

### **Phase 1: Critical Performance Gains** ⚡
1. Cache partnership lookups (most frequently queried)
2. Cache dashboard snippet listings
3. Cache language lists

### **Phase 2: Search & Profile Optimization** 🔍
4. Cache search results
5. Cache user profile data
6. Cache user search results

### **Phase 3: Advanced Optimization** 🚀
7. Implement cache warming
8. Add cache hit/miss monitoring
9. Optimize cache key structure

---

## Cache Key Naming Convention

```
{prefix}:{entity}:{identifier}:{variant}

Examples:
- codemaster-cache:snippets:user:123:dashboard
- codemaster-cache:partnerships:user:123:shared_with_me
- codemaster-cache:languages:user:123:list
- codemaster-cache:search:user:123:q:laravel:lang:php
- codemaster-cache:profile:user:123:partners
```

---

## TTL Strategy

| Cache Type | TTL | Reason |
|------------|-----|--------|
| Partnership IDs | 15 minutes | Changes infrequently, but needs freshness |
| Dashboard Snippets | 5 minutes | User-specific, moderate update frequency |
| Search Results | 2 minutes | Query-specific, needs quick invalidation |
| Language Lists | 1 hour | Changes rarely |
| User Profile | 10 minutes | Moderate update frequency |
| User Search | 5 minutes | Query-specific |

---

## Cache Invalidation Strategy

### **Event-Based Invalidation** (Recommended)
Use Laravel events/listeners to invalidate related caches:

```php
// When snippet is created/updated/deleted
Cache::tags(['snippets', 'user:' . $userId])->flush();

// When partnership changes
Cache::tags(['partnerships', 'user:' . $userId])->flush();

// When user profile updates
Cache::tags(['profile', 'user:' . $userId])->flush();
```

### **Time-Based Expiration**
Use TTLs for automatic expiration (already covered above).

### **Manual Invalidation**
Provide admin commands for cache clearing when needed.

---

## Implementation Examples

### Example 1: Cache Partnership Lookups

**Before:**
```php
$ownersWhoSharedWithMe = DB::table('partnerships')
    ->where('partner_id', $currentUserId)
    ->pluck('user_id')
    ->toArray();
```

**After:**
```php
$cacheKey = "partnerships:user:{$currentUserId}:shared_with_me";
$ownersWhoSharedWithMe = Cache::tags(['partnerships', "user:{$currentUserId}"])
    ->remember($cacheKey, now()->addMinutes(15), function () use ($currentUserId) {
        return DB::table('partnerships')
            ->where('partner_id', $currentUserId)
            ->pluck('user_id')
            ->toArray();
    });
```

### Example 2: Cache Dashboard Snippets

**Before:**
```php
$snippets = Snippet::query()
    ->where(function ($query) use ($currentUserId, $ownersWhoSharedWithMe) {
        // ... complex query
    })
    ->with(['user:id,name', 'files:id,snippet_id,file_name'])
    ->latest()
    ->cursorPaginate(20);
```

**After:**
```php
$cacheKey = "snippets:user:{$currentUserId}:dashboard:" . md5($request->getQueryString());
$snippets = Cache::tags(['snippets', "user:{$currentUserId}"])
    ->remember($cacheKey, now()->addMinutes(5), function () use ($request, $currentUserId, $ownersWhoSharedWithMe) {
        return Snippet::query()
            ->where(function ($query) use ($currentUserId, $ownersWhoSharedWithMe) {
                // ... complex query
            })
            ->with(['user:id,name', 'files:id,snippet_id,file_name'])
            ->latest()
            ->cursorPaginate(20);
    });
```

### Example 3: Cache Language Lists

**Before:**
```php
$languages = DB::table('snippets')
    ->where('user_id', auth()->id())
    ->whereNotNull('language')
    ->distinct()
    ->pluck('language');
```

**After:**
```php
$cacheKey = "languages:user:" . auth()->id();
$languages = Cache::tags(['languages', 'user:' . auth()->id()])
    ->remember($cacheKey, now()->addHour(), function () {
        return DB::table('snippets')
            ->where('user_id', auth()->id())
            ->whereNotNull('language')
            ->distinct()
            ->pluck('language');
    });
```

---

## Configuration Changes Required

### 1. Update `.env` file:
```env
CACHE_STORE=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=0
REDIS_CACHE_DB=1
```

### 2. Ensure Redis is installed and running:
```bash
# Windows (using WSL or Docker)
redis-server

# Or use Laravel Sail
./vendor/bin/sail up -d redis
```

---

## Cache Warming Strategy

Pre-populate frequently accessed caches:

```php
// In a scheduled command or queue job
public function warmCache()
{
    User::chunk(100, function ($users) {
        foreach ($users as $user) {
            // Warm partnership cache
            $this->getPartnershipsForUser($user->id);
            
            // Warm language cache
            $this->getLanguagesForUser($user->id);
        }
    });
}
```

---

## Monitoring & Debugging

### Cache Hit Rate Monitoring
```php
// Add to a service provider or middleware
if (app()->environment('local')) {
    Cache::store('redis')->getRedis()->info('stats');
}
```

### Cache Debugging Commands
```bash
# Clear all cache
php artisan cache:clear

# Clear specific tags
php artisan cache:forget "partnerships:user:123:shared_with_me"

# View cache keys (requires Redis CLI)
redis-cli KEYS "codemaster-cache:*"
```

---

## Best Practices

1. **Always use cache tags** for related data to enable efficient invalidation
2. **Include user ID in cache keys** for user-specific data
3. **Use appropriate TTLs** - balance freshness vs performance
4. **Invalidate on write operations** - keep cache consistent
5. **Monitor cache hit rates** - optimize TTLs based on usage
6. **Use cache locks** for expensive operations to prevent cache stampede
7. **Test cache behavior** in development before deploying

---

## Expected Performance Improvements

- **Dashboard Load Time:** 60-80% reduction (from ~200ms to ~40-80ms)
- **Partnership Queries:** 90% reduction (from ~50ms to ~5ms)
- **Search Results:** 50-70% reduction for repeated queries
- **Database Load:** 40-60% reduction on read-heavy endpoints

---

## Migration Path

1. **Week 1:** Implement partnership caching + dashboard caching
2. **Week 2:** Add language list caching + search result caching
3. **Week 3:** Implement cache invalidation on write operations
4. **Week 4:** Add monitoring and optimize TTLs based on metrics

---

## Notes

- Redis must be installed and running for these strategies to work
- Cache tags require Redis (not available with database/file cache)
- Consider using Redis Cluster for high-availability production setups
- Monitor Redis memory usage and set appropriate `maxmemory` policies
