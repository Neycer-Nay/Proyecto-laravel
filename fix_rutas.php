require 'vendor/autoload.php';
use App\Models\FotoEquipo;

foreach (FotoEquipo::all() as $foto) {
    $foto->ruta = str_replace('public/', '', $foto->ruta);
    $foto->save();
}
echo "Rutas actualizadas correctamente.";
