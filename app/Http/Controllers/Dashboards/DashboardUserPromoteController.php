<?php

namespace App\Http\Controllers\Dashboards;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DashboardUserPromoteController extends Controller
{
    /**
     * Promote a user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function promote(User $user)
    {
        try {
            $user->level = "admin";
            $user->save();
        } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
            return response()->json([
                "message" => "Gagal melakukan promote pengguna."
            ], 422);
        } catch (\Throwable $e) {
            // catch all exceptions here
            return response()->json([
                "message" => "An error occurred: " . $e->getMessage()
            ], 500);
        }

        return response()->json([
            "message" => "Pengguna @$user->username berhasil di-promote menjadi admin!",
        ], 200);
    }

    /**
     * Demote a user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function demote(User $user)
    {
        try {
            $user->level = "officer";
            $user->save();
        } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
            return response()->json([
                "message" => "Gagal melakukan demote pengguna."
            ], 422);
        } catch (\Throwable $e) {
            // catch all exceptions here
            return response()->json([
                "message" => "An error occurred: " . $e->getMessage()
            ], 500);
        }

        return response()->json([
            "message" => "Pengguna @$user->username turun pangkat menjadi officer.",
        ], 200);
    }
}
