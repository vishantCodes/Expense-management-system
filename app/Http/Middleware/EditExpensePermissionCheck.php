<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EditExpensePermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expense = $request->route('expense');

        if (
            !auth()->user()->hasRole('super-admin')
            && $expense->user_id !== auth()->id()
        ) {
            return redirect()
                ->route('admin.expense.index')
                ->with('error', "You cannot edit someone else's expense.");
        }

        return $next($request);
    }
}
