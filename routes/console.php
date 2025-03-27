<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Teams;
use App\Models\User;
use App\Models\Events;
use App\Models\Attendance;
use App\Models\EventTeam;
use App\Models\MembersTeam;
use App\Models\Members;
use App\Models\MembersAchievement;
use App\Models\Achievements;
use App\Models\ShirtSizes;
use App\Models\UserMember;
use Illuminate\Support\Facades\Hash;
use App\Mail\AccountCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('clear:database', function () {
  error_log("Proccessing command...");
  DB::statement('SET FOREIGN_KEY_CHECKS=0;');
  Teams::query()->truncate();
  Events::query()->truncate();
  Attendance::query()->truncate();
  EventTeam::query()->truncate();
  MembersTeam::query()->truncate();
  MembersAchievement::query()->truncate();
  Achievements::query()->truncate();
  ShirtSizes::query()->truncate();
  Members::query()->truncate();
  UserMember::query()->truncate();
  DB::statement('SET FOREIGN_KEY_CHECKS=1;');
  error_log("Database cleared.");

})->purpose('Clears the database.')->onSuccess(function () {
  echo "Clearing Database failed.";
})
->onFailure(function () {
  echo "Clearing Database succeeded";
});

Artisan::command('make:administrator {name} {email} {surname?}', function () {
  error_log("Proccessing command...");
  $name = $this->argument('name');
  $email = $this->argument('email');
  $surname = $this->argument('surname');
  $data = [
    'name' => $name,
    'email' => $email,
    'surname' => $surname,
  ];
  try {
    if ($name && $email) {
      $validator = Validator::make($data, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email:rfc,dns|max:255|unique:users',
        'surname' => 'nullable|string|max:255',
      ]);

      if ($validator->fails()) {
        error_log("Nastala chyba při validaci: " . $validator->errors());
        return;
      }

      $validated = $validator->validated();
      $role = 'admin';
      $string = str()->random(8);
      $password = Hash::make($string);

      User::create([
        'name' => $validated['name'],
        'surname' => $validated['surname'],
        'email' => $validated['email'],
        'role' => $role,
        'password' => $password
      ]);

      Mail::to($email)->send(new AccountCreated($name, $surname ?? null, $string, $email));
    }
    error_log('Administrátor '. $name . ' byl úspěšně přidán a email zaslán! Heslo uživatele je: '. $string);
    error_log("Task finished.");
  } catch(Exception $e) {
    error_log("Task failed: " . $e->getMessage());
  }
})->purpose('Creates an administrator role user with parameters <name> <email> [<surname>]. Email with the password is sent and logged into the servers console.')
->onSuccess(function () {
  echo "Command executed and proccessed with no issues.";
})
->onFailure(function () {
  echo "Executing command failed.";
});
Schedule::call(function () {
  DB::statement('SET FOREIGN_KEY_CHECKS=0;');

  $tables = DB::select('SHOW TABLES');

  foreach ($tables as $table) {
      $tableName = array_values((array) $table)[0];
      if (Schema::hasColumn($tableName, 'deleted_at')) {
          DB::table($tableName)->whereNotNull('deleted_at')->delete();
      }
  }
  DB::statement('SET FOREIGN_KEY_CHECKS=1;');
  error_log("Cleared SoftDeleted items.");
})->cron('0 0 * * *')->onSuccess(function () {
  echo "Clearing SoftDeleted items failed.";
})
->onFailure(function () {
  echo "Clearing SoftDeleted items succeeded";
});
Artisan::command('clear:softdeleted', function () {
  DB::statement('SET FOREIGN_KEY_CHECKS=0;');
  $tables = DB::select('SHOW TABLES');

  foreach ($tables as $table) {
      $tableName = array_values((array) $table)[0];
      if (Schema::hasColumn($tableName, 'deleted_at')) {
          DB::table($tableName)->whereNotNull('deleted_at')->delete();
      }
  }
  DB::statement('SET FOREIGN_KEY_CHECKS=1;');
  error_log("Cleared SoftDeleted items.");
})->onSuccess(function () {
  echo "Clearing SoftDeleted items failed.";
})
->onFailure(function () {
  echo "Clearing SoftDeleted items succeeded";
});
