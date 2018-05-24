<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['dashboard'] = 'admin/dashboard';
$route['updates'] = 'admin/dashboard/updates';
$route['zoek'] = 'admin/zoek';

$route['autos'] = 'admin/autos';
$route['autos/(:num)'] = 'admin/autos/bekijken/$1';
$route['autos/get_kenteken/(:num)'] = 'admin/autos/get_kenteken/$1';
$route['autos/get_kmstand/(:num)'] = 'admin/autos/get_kmstand/$1';
$route['autos/printen'] = 'admin/autos/printen';
$route['autos/toevoegen'] = 'admin/autos/toevoegen';
$route['autos/verwijderen/(:num)'] = 'admin/autos/verwijderen/$1';

$route['koeriers'] = 'admin/koeriers';
$route['koeriers/(:num)'] = 'admin/koeriers/bekijken/$1';
$route['koeriers/get_kosten/(:any)'] = 'admin/koeriers/get_kosten/$1';
$route['koeriers/printen'] = 'admin/koeriers/printen';
$route['koeriers/toevoegen'] = 'admin/koeriers/toevoegen';
$route['koeriers/verwijderen/(:num)'] = 'admin/koeriers/verwijderen/$1';

$route['personeel'] = 'admin/personeel';
$route['personeel/(:num)'] = 'admin/personeel/bekijken/$1';
$route['personeel/historie'] = 'admin/personeel/historie';
$route['personeel/printen'] = 'admin/personeel/printen';
$route['personeel/reset/(:num)'] = 'admin/personeel/reset/$1';
$route['personeel/toevoegen'] = 'admin/personeel/toevoegen';
$route['personeel/verwijderen/(:num)'] = 'admin/personeel/verwijderen/$1';

$route['routes'] = 'admin/routes';
$route['routes/(:num)'] = 'admin/routes/bekijken/$1';
$route['routes/printen'] = 'admin/routes/printen';
$route['routes/toevoegen'] = 'admin/routes/toevoegen';
$route['routes/verwijderen/(:num)'] = 'admin/routes/verwijderen/$1';

$route['steunpunten'] = 'admin/steunpunten';
$route['steunpunten/(:num)'] = 'admin/steunpunten/bekijken/$1';
$route['steunpunten/printen'] = 'admin/steunpunten/printen';
$route['steunpunten/toevoegen'] = 'admin/steunpunten/toevoegen';
$route['steunpunten/verwijderen/(:num)'] = 'admin/steunpunten/verwijderen/$1';

$route['steunpunten/assortiment'] = 'admin/assortiment';
$route['steunpunten/assortiment/aanpassen'] = 'admin/assortiment/aanpassen';
$route['assortiment/verwijderen/(:num)'] = 'admin/assortiment/verwijderen/$1';

/*
 * -------------------------------------------------------------------------
 * REGISTRATIE
 * -------------------------------------------------------------------------
 */

# RITREGISTRATIE
$route['ritregistratie'] = 'admin/ritregistratie';
$route['ritregistratie/(extern|intern)/(:num)'] = 'admin/ritregistratie/bekijken/$1/$2';
$route['ritregistratie/(extern|intern)/json'] = 'admin/ritregistratie/json/$1';
$route['ritregistratie/(extern|intern)/print/(:num)'] = 'admin/ritregistratie/printen/$1/$2';
$route['ritregistratie/extern/statistieken'] = 'admin/ritregistratie/statistieken';
$route['ritregistratie/extern/get_statistics'] = 'admin/ritregistratie/get_statistics';
$route['ritregistratie/(extern|intern)/toevoegen'] = 'admin/ritregistratie/toevoegen/$1';
$route['ritregistratie/intern/sneltoevoegen'] = 'admin/ritregistratie/sneltoevoegen';
$route['ritregistratie/(extern|intern)/verwijderen/(:num)'] = 'admin/ritregistratie/verwijderen/$1/$2';

# STANDAARD RITTEN
$route['ritregistratie/standaardritten'] = 'admin/standaardritten';
$route['ritregistratie/standaardritten/opslaan'] = 'admin/standaardritten/opslaan';
$route['ritregistratie/standaardritten/toevoegen'] = 'admin/standaardritten/toevoegen';
$route['standaardritten/verwijderen/(:num)'] = 'admin/standaardritten/verwijderen/$1';

# PARTICIPANTEN
$route['ritregistratie/participanten'] = 'admin/participanten';
$route['ritregistratie/participanten/aanpassen'] = 'admin/participanten/aanpassen';
$route['participanten/verwijderen/(:num)'] = 'admin/participanten/verwijderen/$1';

# PARTICIPANTEN
$route['ritregistratie/ophaalpunten'] = 'admin/ophaalpunten';
$route['ritregistratie/ophaalpunten/aanpassen'] = 'admin/ophaalpunten/aanpassen';
$route['ritregistratie/ophaalpunten/get_kosten/(:num)'] = 'admin/ophaalpunten/get_kosten/$1';
$route['ophaalpunten/verwijderen/(:num)'] = 'admin/ophaalpunten/verwijderen/$1';

# ZOEKOPTIES
$route['ritregistratie/extern/koeriersoverzicht'] = 'admin/ritregistratie/koeriersoverzicht';
$route['ritregistratie/(extern|intern)/participantoverzicht'] = 'admin/ritregistratie/participantoverzicht/$1';
$route['ritregistratie/(extern|intern)/omschrijvingsoverzicht'] = 'admin/ritregistratie/omschrijvingsoverzicht/$1';
$route['ritregistratie/extern/fo'] = 'admin/ritregistratie/fo';
$route['ritregistratie/extern/factuuroverzicht/(:any)'] = 'admin/ritregistratie/factuuroverzicht/$1';
$route['ritregistratie/intern/routesoverzicht'] = 'admin/ritregistratie/routesoverzicht';
$route['ritregistratie/wo/(extern|intern)'] = 'admin/ritregistratie/wo/$1';
$route['ritregistratie/weekoverzicht/(extern|intern)/(:any)/(:num)'] = 'admin/ritregistratie/weekoverzicht/$1/$2/$3';
$route['ritregistratie/zoek/(:any)'] = 'admin/ritregistratie/zoek/$1';

# BRANDSTOF
$route['brandstof'] = 'admin/brandstof';
$route['brandstof/(:num)'] = 'admin/brandstof/bekijken/$1';
$route['brandstof/autooverzicht'] = 'admin/brandstof/autooverzicht';
$route['brandstof/json'] = 'admin/brandstof/json';
$route['brandstof/toevoegen'] = 'admin/brandstof/toevoegen';
$route['brandstof/verwijderen/(:num)'] = 'admin/brandstof/verwijderen/$1';
$route['brandstof/wo'] = 'admin/brandstof/wo';
$route['brandstof/weekoverzicht/(:num)'] = 'admin/brandstof/weekoverzicht/$1';

/*
 * -------------------------------------------------------------------------
 * ONDERHOUD
 * -------------------------------------------------------------------------
 */

# ONDERHOUD
$route['onderhoud'] = 'admin/onderhoud';
$route['onderhoud/(:num)'] = 'admin/onderhoud/bekijken/$1';
$route['onderhoud/toevoegen'] = 'admin/onderhoud/toevoegen';
$route['onderhoud/verwijderen/(:num)'] = 'admin/onderhoud/verwijderen/$1';

# BEDRIJVEN
$route['onderhoud/bedrijven'] = 'admin/schadebedrijven';
$route['onderhoud/bedrijven/aanpassen'] = 'admin/schadebedrijven/aanpassen';
$route['bedrijven/verwijderen/(:num)'] = 'admin/schadebedrijven/verwijderen/$1';

/*
 * -------------------------------------------------------------------------
 * GEBRUIKERS
 * -------------------------------------------------------------------------
 */

$route['login'] = 'login';
$route['gebruiker/instellingen'] = 'admin/user/index';
$route['gebruiker/logout'] = 'admin/user/logout';
$route['gebruiker/pw'] = 'admin/user/reset_password';

/*
 * -------------------------------------------------------------------------
 * BERICHTEN
 * -------------------------------------------------------------------------
 */

$route['bericht'] = '/admin/bericht';
$route['bericht/get_chat'] = '/admin/bericht/get_chat';


/*
 * -------------------------------------------------------------------------
 * EMBALLAGE
 * -------------------------------------------------------------------------
 */

$route['emballage'] = '/admin/emballage';
$route['emballage/toevoegen'] = '/admin/emballage/toevoegen';
$route['emballage/(:num)'] = 'admin/emballage/bekijken/$1';
$route['emballage/verwijderen/(:num)'] = 'admin/emballage/verwijderen/$1';
$route['emballage/bewerken/(:num)'] = 'admin/emballage/bewerken/$1';
$route['emballage/printen'] = '/admin/emballage/printen';
/*
 * -------------------------------------------------------------------------
 * EMBALLAGE_MEE
 * -------------------------------------------------------------------------
 */
$route['emballage_mee'] = '/admin/emballage_mee';
$route['emballage_mee/verwijderen/(:num)'] = 'admin/emballage_mee/verwijderen/$1';
$route['emballage_mee/aanpassen'] = '/admin/emballage_mee/aanpassen';

/*
 * -------------------------------------------------------------------------
 * EMBALLAGE_RETOUR
 * -------------------------------------------------------------------------
 */
$route['emballage_retour'] = '/admin/emballage_retour';
$route['emballage_retour/verwijderen/(:num)'] = 'admin/emballage_retour/verwijderen/$1';
$route['emballage_retour/aanpassen'] = '/admin/emballage_retour/aanpassen';




# DEFAULT
$route['default_controller'] = 'login';

