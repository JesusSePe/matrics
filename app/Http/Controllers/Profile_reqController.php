<?php

namespace App\Http\Controllers;

use App\Models\Req_enrol;
use App\Models\Profile_req;
use App\Models\Requirement;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Profiler\Profile;

class Profile_reqController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$data = ['status' => 'Unauthorized, error 503'];
		$token = $request->header('token');
		if ($token) {
			$user = User::select("token")->where('token', $token)->get()[0];
			if ($user['token']) {
				$data = Profile_req::all();
				if (sizeof($data) == 0) {
					return response()->json(['status' => "warning", "text" => 'No hi ha cap perfil.']);
				} else {
					return response()->json($data);
				}
			}
		}
		return response()->json($data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	// public function create()
	// {
	//     //
	// }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$data = ['status' => 'Unauthorized, error 503'];
		$token = $request->header('token');
		if ($token) {
			$user = User::select("token")->where('token', $token)->where("role", "admin")->get()[0];
			if ($user['token']) {

				$pro = new Profile_req;
				$pro->name = $request->name;

				$status = $pro->save();
				if ($status) {
					$data = ["status" => "success", "text" => "Nou perfil de requeriments creat correctament."];
					Log::channel('dblogging')->info("Ha creado un nuevo perfil de requerimientos", ["user_id" => Auth::id(), "profile_reqs_id" => $pro->id]);
				}
			}
			if (isset($data['status'])) {
				Log::channel('dblogging')->info("No se ha enviado token de identificación en la request. Conexión rechazada. HTTP 503", ["user_id" => null, "requirement_id" => null]);
			}
			return response()->json($data);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Profile_req  $pro
	 * @return \Illuminate\Http\Response
	 */
	// public function show(Profile_req $pro)
	// {
	//     //
	// }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Profile_req  $pro
	 * @return \Illuminate\Http\Response
	 */
	// public function edit(Profile_req $pro)
	// {
	//     //
	// }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Perfil_reqs  $pro
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Profile_req $pro)
	{
		$data = ['status' => 'Unauthorized, error 500'];
		$token = $request->header('token');
		if ($token) {
			$user = User::select("token")->where('token', $token)->where("role", "admin")->get()[0];
			if ($user['token']) {
				$pro = Profile_req::select("*")->where("id", $request->id)->get()[0];
				$pro->name = $request->name;
				$pro->touch();
				$status = $pro->update();

				if ($status) {
					$data = ["status" => "success", "text" => "Perfil de requeriments actualitzat correctament."];
					Log::channel('dblogging')->info("Ha actualizado un perfil de requerimientos", ["user_id" => Auth::id(), "profile_reqs" => $pro->id]);
				} else {
					Log::channel('dblogging')->info("Fallo al actualizar el perfil. No se ha encontrado el perfil de requerimientos a modificar.");
					$data = ["status" => "Perfil de requeriments NO actualitzat."];
				}
			}
		}
		if (isset($data['status'])) {
			Log::channel('dblogging')->info("No se ha enviado token de identificación en la request. Conexión rechazada. HTTP 503", ["user_id" => null, "requirement_id" => null]);
		}
		return response()->json($data);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Profile_req  $pro
	 * @return \Illuminate\Http\Response
	 */
	// public function destroy(Profile_req $pro)
	// {
	//     //
	// }
	public function destroy(Request $request, Profile_req $pro)
	{
		$id = $request->id;
		Schema::disableForeignKeyConstraints();
		Requirement::where('profile_id', $id)->delete();
		$status = Profile_req::destroy($id);
		Schema::enableForeignKeyConstraints();

		if ($status) {
			return response()->json(["status" => "success", "text" => "Perfil esborrat correctament."]);
		} else {
			return response()->json(["status" => "error", "text" => "No s'ha pogut esborrar el perfil."]);
		}
	}
}
