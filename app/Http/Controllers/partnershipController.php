<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class partnershipController extends Controller
{
    private function invalidateUserSnippetCaches(int $userId)
    {
        // Delete specific known cache keys
        Cache::forget("languages:user:{$userId}:list");

        // Try to delete snippet and search caches by pattern if Redis is available
        $store = Cache::getStore();
        if (method_exists($store, 'getRedis')) {
            try {
                $redis = $store->getRedis();
                $prefix = Cache::getPrefix();

                // Delete snippet caches
                $pattern = $prefix . "snippets:user:{$userId}:*";
                $keys = $redis->keys($pattern);
                if (! empty($keys)) {
                    $redis->del($keys);
                }

                // Delete search caches
                $pattern = $prefix . "search:user:{$userId}:*";
                $keys = $redis->keys($pattern);
                if (! empty($keys)) {
                    $redis->del($keys);
                }
            } catch (Exception $e) {
                // If Redis pattern matching fails, just continue
                // Cache will expire naturally via TTL
            }
        }
    }

    public function PartnerPermission(Request $request)
    {
        //  return $request;
        try {
            // return $request;
            $currentUserId = auth()->id();

            if ($currentUserId == null) {
                return view('auth.login')->with(
                    'error',
                    'Please sign in to access this page.',
                );
            }
            // save permission to database
            DB::table('partnerships')
                ->where('user_id', $currentUserId)
                ->where('partner_id', $request->input('partner_id'))
                ->update([
                    'is_read' => $request->input('is_read'),
                    'is_edit' => $request->input('is_edit'),
                ]);

            return back()->with('success', 'Permission updated successfully');
        } catch (Exception $e) {
            return back()->with(
                'error',
                'An error occurred while updating permission.',
            );
        }
    }

    public function destroyPartner($id)
    {
        // return $id;

        try {
            // Find the partnership record while ensuring
            $partnership = DB::table('partnerships')
                ->where('partner_id', $id)
                ->where('user_id', auth()->id())
                ->first();

            // return $partnership;

            if (! $partnership) {
                return back()->with(
                    'error',
                    'Partner not found or you are not authorized to perform this action.',
                );
            }

            $userId = auth()->id();

            // Delete the partnership record from the database
            DB::table('partnerships')
                ->where('partner_id', $id)
                ->where('user_id', $userId)
                ->delete();

            // Invalidate partnership caches for both users
            Cache::forget("partnerships:user:{$userId}:shared_with_me");
            Cache::forget("partnerships:user:{$id}:shared_with_me");
            $this->invalidateUserSnippetCaches($userId);
            $this->invalidateUserSnippetCaches($id);

            // Return success message on successful deletion
            return back()->with(
                'success',
                'Partner has been removed successfully.',
            );
        } catch (Exception $e) {
            return back()->with(
                'error',
                'Something went wrong while removing the partner. Please try again.',
            );
        }
    }
}
