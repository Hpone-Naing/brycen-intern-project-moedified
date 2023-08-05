<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ConstantKeys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\EmployeeRepository;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $employeeRepository = app(EmployeeRepository::class);
        $username = $request->username;
        $password = $request->password;
        $employee = $employeeRepository->getEmployeesByEmployeeIdOptionalColumns(["id", "employee_id", "name", "password", "role_id", "image"], $username);
        $request->session()->put('logedinId', $employee->id);
        $request->session()->put('logedinEmployeeId', $employee->employee_id);
        $request->session()->put('logedinEmployeeName', $employee->name);
        $request->session()->put('logedinEmployeeRole', $employee->role_id);
        $request->session()->put('logedinEmployeePhoto', $employee->image);
        if(!$employee || !isset($employee)) {
            return new Response(view("authentication.login")->with("error", "Invalid Credentials")->render());
        }
        if ($username == $employee->employee_id) {
            if (Hash::check($password, $employee->password)) {
                
                return $next($request);
            }
        return new Response(view("authentication.login")->with("error", "Invalid Credentials")->render());
        } 
        return new Response(view("authentication.login")->with("error", "Invalid Credentials")->render());
        // return new Response(view("authentication.login")->with("error", "Invalid Credentials"));
    }
}
