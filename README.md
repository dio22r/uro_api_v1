# API for uro-apps

## List of API End Point

+--------+-----------------------------------+----------------------------------------------------+
| Method | Route | Handler |
+--------+-----------------------------------+----------------------------------------------------+
| GET | api/logout | \App\Controllers\UserController::logout |
| GET | api/aktivasi/([^/]+) | \App\Controllers\UserController::aktivasi/$1 |
| GET | api/reset_password/([^/]+) | \App\Controllers\UserController::reset_password/$1 |
| GET | api/user | \App\Controllers\UserController::show |
| POST | api/login | \App\Controllers\UserController::login |
| POST | api/register | \App\Controllers\UserController::register |
| POST | api/aktivasi | \App\Controllers\UserController::resend_aktivasi |
| POST | api/forgot | \App\Controllers\UserController::forgot_password |
| POST | api/user/profile | \App\Controllers\UserController::update |
| POST | api/user/akun | \App\Controllers\UserController::update_akun |
| POST | api/user/password | \App\Controllers\UserController::update_password |

| GET | api/rekanku | \App\Controllers\RekankuController::index |
| GET | api/rekanku/([0-9]+) | \App\Controllers\RekankuController::show/$1 |

| GET | api/tugasku | \App\Controllers\TugaskuController::index |
| GET | api/tugasku/([0-9]+) | \App\Controllers\TugaskuController::show/$1 |

| GET | api/proyekku | \App\Controllers\ProyekkuController::index |
| GET | api/proyekku/([0-9]+) | \App\Controllers\ProyekkuController::show/$1 |
| POST | api/proyekku | \App\Controllers\ProyekkuController::create |
| PUT | api/proyekku/([0-9]+) | \App\Controllers\ProyekkuController::update/$1 |
| DELETE | api/proyekku/([0-9]+) | \App\Controllers\ProyekkuController::delete/$1 |

| GET | api/proyekku/([0-9]+)/todo | \App\Controllers\TodoController::index/$1 |
| POST | api/proyekku/([0-9]+)/todo | \App\Controllers\TodoController::create/$1 |
| PUT | api/proyekku/todo/([0-9]+) | \App\Controllers\TodoController::update/$1 |

| GET | api/proyekku/todo/([0-9]+)/detail | \App\Controllers\TodoDetailController::index/$1 |
| POST | api/proyekku/todo/([0-9]+)/detail | \App\Controllers\TodoDetailController::insert/$1 |
| PUT | api/proyekku/todo/detail/([0-9]+) | \App\Controllers\TodoDetailController::update/$1 |
| DELETE | api/proyekku/todo/detail/([0-9]+) | \App\Controllers\TodoDetailController::delete/$1 |
+--------+-----------------------------------+----------------------------------------------------+
