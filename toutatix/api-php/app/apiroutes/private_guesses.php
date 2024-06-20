<?php

require_once __DIR__ . '/../auth/JwtHandler.php';
require_once __DIR__ . '/../auth/Exceptions.php';
require_once __DIR__ . '/../db/DBConnection.php';
require_once __DIR__ . '/../utils/AutoDeleteStream.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


/**
 * Get History (see documentation)
 */
$app->get('/api/guesses', function (Request $request, Response $response) {

    // Do a try catch which try to get user infos from token 
    // (using get_token_infos function which throw exception if token is wrong)
    try {
        /* TODO */

        $userinfo = get_token_infos($request);
        $username = $userinfo->username;

        try {
            // From DB, get all guesses and return json array with all infos (see swagger api response format)
            // (response code should be 200 if everything is OK)
            /* TODO */

            $dbconn = new DB\DBConnection();
            $db = $dbconn->connect();

            // prepare sql query
            $sql = "SELECT * FROM guesses";
            $stmt = $db->prepare($sql);

            // query
            $stmt->execute();

            // get all guesses
            $guesses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // close db connection
            $db = null;

            foreach ($guesses as &$guess) {
                $date = date(DATE_RFC2822, $guess['id'] / 1000);
                $guess['date'] = $date;
            }

            // return response with guesses data
            $response->getBody()->write(json_encode($guesses));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);


        } catch (PDOException $e) {
            // response : 500 : PDO Error (DB)
            $response->getBody()->write('{"success": false, "message": "' . $e->getMessage() . '"}');
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);

        }
    } catch (Auth\UnauthenticatedException $e) {
        //response : 401 : catch UnauthenticatedException : Authentication Error
        $response->getBody()->write('{"success": false, "message": "' . $e->getMessage() . '"}');
        return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
    } catch (Exception $e) {
        // Response 500 : Error
        $response->getBody()->write('{"error": {"msg": "' . $e->getMessage() . '"}}');
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }


});

/**
 * Download History Images classed by Character (Asterix / Obelix) and good or bad prediction :
 * 
 * ../Images
 *   |__ Asterix
 *       |__ GoodPred
 *       |__ BadPred
 *   |__ Obelix 
 *       |__ GoodPred
 *       |__ BadPred
 * 
 * (Images with no feedback (win == NULL) or with feedback Stalemate (win == 0) are not downloaded)
 */
$app->get('/api/guesses/images', function (Request $request, Response $response) {
    //retrieve upload directory from config
    // the zip file will be temparary stored inside $directory root folder
    $directory = $this->get('upload_directory');


    // Do a try catch which try to get user infos from token 
    // (using get_token_infos function which throw exception if token is wrong)
    try {
        /* TODO */
        $userinfo = get_token_infos($request);
        $username = $userinfo->username;
        try {
            // Browse History entries from DB (table guesses) and add downloadable images as entries in a zip archive
            // You should use createZip Function :)
            //
            // /!\ must produce 2 variable :
            // - $filepath : path to the zip file (ex: /data/uploads/archive.zip)
            // - $filename : file name of the zip file (ex : archive.zip)

            /* TODO */

            //connect to DB
            $dbconn = new DB\DBConnection();
            $db = $dbconn->connect();

            // prepare sql query
            $sql = "SELECT * FROM guesses WHERE win IS NOT NULL AND win <> 0";
            $stmt = $db->prepare($sql);

            // query
            $stmt->execute();

            // get all guesses
            $guesses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // close db connection
            $db = null;

            $filespaths = [];
            $entriesnames = [];

            foreach ($guesses as $guess) {
                $filespaths[] = $guess['imagepath'];

                $character = $guess['guess'];
                $prediction = ($guess['win'] > 0) ? 'GoodPred' : 'BadPred';

                // If win is -1, reverse the character
                if ($guess['win'] == -1) {
                    $character = ($character == 'Asterix') ? 'Obelix' : 'Asterix';
                }

                $entriesnames[] = "Images/$character/$prediction/" . basename($guess['imagepath']);
            }

            $filename = 'archive.zip';
            $filepath = $directory . DIRECTORY_SEPARATOR . $filename;

            createZip($filespaths, $entriesnames, $filepath);


            // return the response (code 200) containing the zip file as stream.
            return $response->withHeader('Content-Type', 'application/zip')
                ->withHeader('Content-Disposition', 'attachment; filename=' . $filename)
                ->withHeader('Content-Length', filesize($filepath))
                ->withBody(AutoDeleteStream::createFromFilePath($filepath));
        } catch (PDOException $e) {
            // response : 500 : PDO Error (DB)
            $response->getBody()->write('{"success": false, "message": "' . $e->getMessage() . '"}');
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);

        }
    } catch (Auth\UnauthenticatedException $e) {
        //response : 401 : catch UnauthenticatedException : Authentication Error
        $response->getBody()->write('{"success": false, "message": "' . $e->getMessage() . '"}');
        return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
    } catch (Exception $e) {
        // Response 500 : Error
        $response->getBody()->write('{"error": {"msg": "' . $e->getMessage() . '"}}');
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }

});

/**
 * Delete all entries from History & cleaning upload directory folder (delete file from FileSystem)
 * /!\ This method is authorized only for user with admin flag (Asterix)
 */
$app->delete('/api/guesses', function (Request $request, Response $response) {
    //retrieve upload directory from config
    $directory = $this->get('upload_directory');

    // Do a try catch which try to get user infos from token 
    // (using get_token_infos function which throw exception if token is wrong)
    try {
        //retrieve admin field from token user info and if admin => Do All Deletions / else not admin => throw 403 response

        $userinfo = get_token_infos($request);
        $admin = $userinfo->admin;

        if ($admin) {

            // Do delete from DB & FileSystem
            /* TODO */
            //connect to DB
            $dbconn = new DB\DBConnection();
            $db = $dbconn->connect();

            // prepare sql query to delete all guesses
            $sql = "DELETE FROM guesses";
            $stmt = $db->prepare($sql);

            // execute deletion
            $stmt->execute();

            // close db connection
            $db = null;

            // delete all files from upload directory
            $files = glob($directory . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }

            $response->getBody()->write('{"success": true, "message": "All guesses deleted !"}');
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write('{"success": false, "message": "Access Denied : Not Allowed Operation with user\'s privilege"}');
            return $response->withHeader('Content-Type', 'application/json')->withStatus(403);
        }

    } catch (Auth\UnauthenticatedException $e) {
        //response : 401 : catch UnauthenticatedException : Authentication Error
        $response->getBody()->write('{"success": false, "message": "' . $e->getMessage() . '"}');
        return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
    } catch (Exception $e) {
        // Response 500 : Error
        $response->getBody()->write('{"error": {"msg": "' . $e->getMessage() . '"}}');
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});



/**
 * Create Zip : 
 * - $filespaths : array of every files (images paths) to add (ex: /data/uploads/1714995215898.jpg )
 * - $entriesname : array of entries destination path (ex: Images/Obelix/GoodPred/1714995215898.jpg )
 * - out zip file path (ex: /data/uploads/archive.zip)
 */
function createZip($filespaths, $entriesnames, $zipFileName)
{
    // Create instance of ZipArchive. and open the zip folder.
    $zip = new \ZipArchive();
    if ($zip->open($zipFileName, \ZipArchive::CREATE) !== TRUE) {
        exit("cannot open <$zipFileName>\n");
    }

    // Adding every attachments files into the ZIP.
    for ($i = 0; $i < count($filespaths); $i++) {
        $filepath = $filespaths[$i];
        $entryname = $entriesnames[$i];

        $zip->addFile($filepath, $entryname);
    }
    $zip->close();
}


/**
 * Function which parse token, decode user infos from this token and Throws UnauthenticatedException if Autthentication Issue.
 * 
 * The UnauthenticatedException must be catched in the caller and should result to a 401 Http Error
 */
function get_token_infos(Request $request)
{


    if ($request->hasHeader('Authorization')) {
        list($token) = sscanf($request->getHeaderLine('Authorization'), 'Bearer %s');

        $jwt = new Auth\JwtHandler();
        try {
            $data = $jwt->_jwt_decode_data($token);

            return $data;
        } catch (Exception $e) {
            throw new Auth\UnauthenticatedException("Invalid token : " . $e->getMessage());
        }


    } else {
        throw new Auth\UnauthenticatedException("Unable to find Authorization Header");
    }
}


?>