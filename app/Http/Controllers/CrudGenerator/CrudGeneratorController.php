<?php

namespace App\Http\Controllers\CrudGenerator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CrudGeneratorController extends Controller
{
    public function index()
    {
        return view('crud_generator.index');
    }

  public function generate(Request $request)
{
    $request->validate([
        'table_name' => 'required|string',
        'fields' => 'required|string',
    ]);

    $tableName = Str::snake($request->table_name);
    $modelName = Str::studly($request->table_name);
    $routeName = Str::plural(Str::kebab($modelName)) . '.index';
    $fields = explode(',', $request->fields);

    $migrationFields = collect($fields)->map(function ($field) {
        return "\$table->string('$field');";
    })->implode("\n            ");

    // Generate migration
    $migrationFile = base_path("database/migrations/") . date('Y_m_d_His') . "_create_{$tableName}_table.php";
    file_put_contents($migrationFile, <<<EOD
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('$tableName', function (Blueprint \$table) {
            \$table->id();
            $migrationFields
            \$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('$tableName');
    }
};
EOD
);

    // Generate model
    $modelPath = app_path("Models/$modelName.php");
    file_put_contents($modelPath, <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class $modelName extends Model
{
    protected \$table = '$tableName';
    protected \$guarded = [];
}
EOD
);

    // Create sidebar menu item
    \DB::table('menus')->insert([
        'name' => $modelName,
        'route' => $routeName,
        'icon' => 'ti ti-circle',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return redirect()->back()->with('success', 'Migration, model, and menu generated successfully. Run "php artisan migrate" to apply migration.');
}
}