<?php namespace App\Http\Middleware;
// First copy this file into your middleware directoy
use App;
use Closure;
use Session;
use App\Modules\User\Models\Role;
use App\Modules\User\Models\User;



class CheckRole{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get the required roles from the route
        $roles = $this->getRequiredRoleForRoute($request->route());

        // Check if a role is required for the route, and
        // if so, ensure that the user has that role.

        $currentUserId = Session::get('currentUser');
        $currentUserRole = User::getCurrentUser($currentUserId);
        $currentRole = Role::getCurrentRole($currentUserRole->role_id)->name;
        if( in_array($currentRole,$roles))
        {
            return $next($request);
        }
//        return response([
//            'error' => [
//                'code' => 'INSUFFICIENT_ROLE',
//                'description' => 'You are not authorized to access this resource.'
//            ]
//        ], 403);
        return App::abort(403, 'Access denied');
    }
    private function getRequiredRoleForRoute($route)
    {
        $actions = $route->getAction();
        return isset($actions['roles']) ? $actions['roles'] : null;
    }
}