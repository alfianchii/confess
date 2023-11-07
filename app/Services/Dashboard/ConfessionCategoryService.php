<?php

namespace App\Services\Dashboard;

use App\Exports\Confessions\Categories\ConfessionCategoriesExport;
use App\Models\{MasterConfessionCategory, User, MasterRole};
use App\Models\Traits\Exportable;
use App\Services\Service;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Storage, Validator};

class ConfessionCategoryService extends Service
{
  // ---------------------------------
  // TRAITS
  use Exportable;


  // ---------------------------------
  // PROPERTIES
  protected array $rules = [
    "category_name" => ["required", "max:255"],
    "image" => ["image", "file", "max:5120"],
    "description" => ["required"],
    "slug" => ["required", "unique:mst_confession_categories,slug"],
  ];

  protected array $messages = [
    "category_name.required" => "Nama kategori harus diisi.",
    "category_name.max" => "Nama kategori maksimal :max karakter",
    "image.image" => "Gambar kategori harus berupa :file.",
    "image.file" => "File harus berupa :file.",
    "image.max" => "Ukuran gambar maksimal :max KiB.",
    "description.required" => "Deskripsi harus diisi.",
    "slug.required" => "Slug harus diisi.",
    "slug.unique" => "Slug sudah digunakan.",
  ];


  // ---------------------------------
  // CORES
  public function index(User $user, MasterRole $userRole)
  {
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminIndex($user);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function create(MasterRole $userRole)
  {
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminCreate();

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function store(Request $request, User $user, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminStore($data, $user);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function edit(MasterRole $userRole, MasterConfessionCategory $confessionCategory)
  {
    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminEdit($confessionCategory);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function update(Request $request, User $user, MasterRole $userRole, MasterConfessionCategory $confessionCategory)
  {
    // Data processing
    $data = $request->all();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminUpdate($data, $user, $confessionCategory);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function destroy(User $user, MasterRole $userRole, string $slug)
  {
    // Data processing
    $confessionCategory = MasterConfessionCategory::where("slug", $slug)->first();
    if (!$confessionCategory) $this->responseJsonMessage("The data you are looking not found.", 404);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminDestroy($user, $confessionCategory);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }

  public function export(Request $request, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminExport($data);

    // Redirect to unauthorized page
    return view("errors.403");
  }

  public function destroyImage(User $user, MasterRole $userRole, string $slug)
  {
    // Data processing
    $confessionCategory = MasterConfessionCategory::where("slug", $slug)->first();
    if (!$confessionCategory->image) return $this->responseJsonMessage("The data you are looking not found.", 404);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminDestroyImage($user, $confessionCategory);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }

  public function activate(User $user, MasterRole $userRole, string $slug)
  {
    // Data processing
    $confessionCategory = MasterConfessionCategory::where("slug", $slug)->first();
    if (!$confessionCategory) $this->responseJsonMessage("The data you are looking not found.", 404);

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminActivate($user, $confessionCategory);

    // Redirect to unauthorized page
    return $this->responseJsonMessage("You are unauthorized to do this action.", 422);
  }

  public function checkSlug(Request $request, MasterRole $userRole)
  {
    // Data processing
    $data = $request->all();

    // Roles checking
    $roleName = $userRole->role_name;
    if ($roleName === "admin") return $this->adminCheckSlug($data);

    // Redirect to unauthorized page
    return view("errors.403");
  }


  // ---------------------------------
  // UTILITIES
  // ADMIN
  // Index
  private function adminIndex()
  {
    $confessionCategories = MasterConfessionCategory::with(["confessions"])
      ->orderBy("category_name", "asc")
      ->get();

    // Passing out a view
    $viewVariables = [
      "title" => "Kategori Pengakuan",
      "confessionCategories" => $confessionCategories,
    ];
    return view("pages.dashboard.actors.admin.confession-categories.index", $viewVariables);
  }
  // Create
  private function adminCreate()
  {
    // Passing out a view
    $viewVariables = [
      "title" => "Buat Kategori",
    ];
    return view("pages.dashboard.actors.admin.confession-categories.create", $viewVariables);
  }
  // Store
  private function adminStore($data, User $user)
  {
    // Validates
    $credentials = Validator::make($data, $this->rules, $this->messages)->validate();
    $credentials = $this->imageCropping($data["image"] ?? null, $credentials, "image", "confession/category/images");
    $credentials["created_by"] = $user->id_user;

    try {
      MasterConfessionCategory::create($credentials);
    } catch (\Exception $e) {
      return redirect('/dashboard/confessions/confession-categories')->withErrors($e->getMessage());
    }

    // Success
    return redirect('/dashboard/confessions/confession-categories')->withSuccess('Kategori pengakuan berhasil dibuat!');
  }
  // Edit
  private function adminEdit(MasterConfessionCategory $confessionCategory)
  {
    // Passing out a view
    $viewVariables = [
      "title" => "Sunting Kategori",
      "confessionCategory" => $confessionCategory,
    ];
    return view("pages.dashboard.actors.admin.confession-categories.edit", $viewVariables);
  }
  // Update 
  private function adminUpdate($data, User $user, MasterConfessionCategory $confessionCategory)
  {
    // Rules
    $rules = $this->slugRules($this->rules, $data['slug'], $confessionCategory->slug);

    // Validates
    $credentials = Validator::make($data, $rules, $this->messages)->validate();
    $credentials = $this->imageCropping($confessionCategory->image, $credentials, "image", "confession/category/images");

    return $this->modify($confessionCategory, $credentials, $user->id_user, "kategori pengakuan", "/dashboard/confessions/confession-categories");
  }
  // Destroy 
  private function adminDestroy(User $user, $confessionCategory)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isActiveData($confessionCategory->flag_active);
      // Restrict if there are confessions
      if ($confessionCategory->confessions()->count() > 0) throw new \Exception("Pengakuan dalam kategori ini mencegah penghapusan kategori.");
      // Destroy the response
      if (!MasterConfessionCategory::destroy($confessionCategory->id_confession_category)) throw new \Exception("Error deleting confession's category.");
      // Non-active data and updated by
      $confessionCategory->refresh();
      $confessionCategory->update(["updated_by" => $user->id_user, "flag_active" => "N", "deleted_at" => null]);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Kategori pengakuan $confessionCategory->category_name telah dinonaktifkan!");
  }
  // Export
  public function adminExport($data)
  {
    // Validates
    $validator = $this->exportValidates($data);
    if ($validator->fails()) return view("errors.403");
    $creds = $validator->validate();

    // File name
    $fileName = $this->getExportFileName($creds["type"]);

    // Table
    if ($creds["table"] === "confession-categories")
      return (new ConfessionCategoriesExport)->download($fileName);
  }
  // Destroy image
  private function adminDestroyImage(User $user, $confessionCategory)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isActiveData($confessionCategory->flag_active);
      // Destroy the image if exists
      if ($confessionCategory->image) Storage::delete($confessionCategory->image);
      $confessionCategory->update(["updated_by" => $user->id_user, "image" => null]);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Foto kategori pengakuan telah dihapus!");
  }
  // Activate
  private function adminActivate(User $user, $confessionCategory)
  {
    try {
      // ---------------------------------
      // Validations
      $this->isNonActiveData($confessionCategory->flag_active);
      // Activate the data
      $confessionCategory->update(["updated_by" => $user->id_user, "flag_active" => "Y", "deleted_at" => null]);
    } catch (\PDOException | ModelNotFoundException | QueryException | \Exception $e) {
      return $this->responseJsonMessage($e->getMessage(), 500);
    } catch (\Throwable $e) {
      // Catch all exceptions here
      return $this->responseJsonMessage("An error occurred: " . $e->getMessage(), 500);
    }

    // Success
    return $this->responseJsonMessage("Kategori pengakuan telah diaktivasi!");
  }
  // Check slug
  public function adminCheckSlug($data)
  {
    $slug = SlugService::createSlug(MasterConfessionCategory::class, "slug", $data['category_name']);

    return response()->json(["slug" => $slug]);
  }
}
