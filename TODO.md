# Dashboard Fixes - Search, Oldest Dropdown, Star Functionality

## Current Progress
- [x] Created TODO.md with plan

## Plan Steps
1. [ ] **resources/views/user/dashboard.blade.php**
   - Change `x-data="snippetManager()"` to `x-data="snippetBrowser()"`
   - Add per-snippet star button with toggle logic
   - Ensure star shows filled if `snippet.isMark`

2. [ ] **resources/views/layout/app.blade.php** (Alpine JS)
   - Add `sortBy: 'latest'` to snippetBrowser() data
   - Update `fetchSnippets()` URL: add `&sort=${this.sortBy}&status=${this.statusFilter}`
   - Add `toggleStar(id)` method: POST to `/snippet-marked`, refetch snippets

3. [ ] **app/Http/Controllers/SnippetController.php**
   - In `search()`: Add handling for `sort` (oldest/az/za/latest), `status` (1/0), select `'isMark'`
   - Update query before `paginate()`

4. [ ] **Testing & Cleanup**
   - Clear cache: `php artisan cache:clear`
   - Test search, sort (oldest), star toggle
   - Update TODO progress

**Next Step:** Edit dashboard.blade.php
