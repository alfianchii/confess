<?php

namespace App\Imports\Users;

use App\Models\{User, MasterRole};
use App\Models\Traits\Helpers\Accountable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{Hash, Validator};
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\{
    ToCollection,
    Importable,
    WithValidation,
    WithHeadingRow,
};
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class UsersImport implements ToCollection, WithValidation, WithHeadingRow
{
    //  ---------------------------------
    // TRAITS
    use Importable, Accountable;


    // ---------------------------------
    // PROPERTIES


    // ---------------------------------
    // HELPERS
    public function getRoleId(string $roleName)
    {
        return MasterRole::where("role_name", $roleName)->value("id_role");
    }
    public function makeCredentials($data)
    {
        $uniqueLength = strlen($data["Unique"]);

        $credentials = [
            "full_name" => $data["Full name"],
            "username" => $data["Username"],
            "nik" => $data["NIK"],
            "role" => $this->getRoleId($data["Role"]),
            "gender" => $data["Gender"],
            "email" => $data["Email"],
            "password" => $data["Password"],
            "flag_active" => $data["Active"],
        ];

        if ($data["Role"] === "officer") {
            $data["key"] = "nip 18";
            if ($uniqueLength === 18) {
                $credentials["nip"] = $data["Unique"];
                return $credentials;
            }
        }
        if ($data["Role"] === "student") {
            $data["key"] = "nisn 16";
            if ($uniqueLength === 16) {
                $credentials["nisn"] = $data["Unique"];
                return $credentials;
            }
        }

        throw new \Exception("Atribut Unique harus merupakan data unik sebagai " . ucwords($data["Role"]) . " (" . strtoupper($data["key"]) . ")" . ".");
    }


    // ---------------------------------
    // CORES
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                $credentials = $this->makeCredentials($row);
                $theUser = User::create($credentials);
                $theUser = $this->createRoleUser($theUser, $credentials);
                $theUser = $this->createUniqueUser($theUser, $credentials["role"], $credentials);
            } catch (\Exception $e) {
                return back()->withErrors($e->getMessage());
            }
        }
    }

    public function rules(): array
    {
        return [
            "Full name" => ["required", "max:255"],
            "Username" => ["required", "unique:mst_users,username", "min:3", "max:30"],
            "NIK" => ["required", "digits:16", "numeric", "unique:mst_users,nik"],
            "Role" => [
                "required",
                function ($attribute, $value, $fail) {
                    if (!$this->getRoleId($value))
                        $fail('Atribut ' . $attribute . ' tidak bisa diidentifikasi.');
                    if ($value === "admin")
                        $fail('Atribut ' . $attribute . ' tidak bisa menambahkan Admin.');
                },
            ],
            "Unique" => [
                "required",
                "numeric",
                function ($attribute, $value, $fail) {
                    $length = strlen($value);
                    if ($length === 18) return "unique:dt_officers,nip";
                    if ($length === 16) return "unique:dt_students,nisn";
                    return $fail("Atribut " . $attribute . " harus memiliki 16 atau 18 karakter.");
                },
            ],
            "Gender" => ["required"],
            "Email" => ["nullable", "unique:mst_users,email", "email:rfc,dns"],
            "Password" => ['required', 'min:6'],
            "Active" => ["required"],
        ];
    }

    public function customValidationMessages()
    {
        return [
            "Full name.required" => "Atribut Full name tidak boleh kosong.",
            "Full name.max" => "Atribut Full name tidak boleh lebih dari :max karakter.",
            "Username.required" => "Atribut Username tidak boleh kosong.",
            "Username.unique" => "Atribut Username sudah terdaftar.",
            "Username.min" => "Atribut Username tidak boleh kurang dari :min karakter.",
            "Username.max" => "Atribut Username tidak boleh lebih dari :max karakter.",
            "NIK.required" => "Atribut NIK tidak boleh kosong.",
            "NIK.digits" => "Atribut NIK harus memiliki :digits karakter.",
            "NIK.numeric" => "Atribut NIK harus berupa angka.",
            "NIK.unique" => "Atribut NIK sudah terdaftar.",
            "Unique.required" => "Atribut Unique tidak boleh kosong.",
            "Unique.digits" => "Atribut Unique harus memiliki :digits karakter.",
            "Unique.numeric" => "Atribut Unique harus berupa angka.",
            "Unique.unique" => "Atribut Unique sudah terdaftar.",
            "Gender.required" => "Jenis kelamin tidak boleh kosong.",
            "Email.unique" => "Email sudah digunakan.",
            "Email.email" => "Email harus valid.",
            "Password.required" => "Password tidak boleh kosong.",
            "Active.required" => "Active tidak boleh kosong.",
        ];
    }


    // ---------------------------------
    // UTILITIES
}
