<?php

namespace PHPMaker2021\sppsampah;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

/**
 * Class others controller
 */
class OthersController extends ControllerBase
{
    // error
    public function error(Request $request, Response $response, array $args): Response
    {
        global $Error;
        $Error = $this->container->get("flash")->getFirstMessage("error");
        return $this->runPage($request, $response, $args, "Error");
    }

    // personaldata
    public function personaldata(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PersonalData");
    }

    // login
    public function login(Request $request, Response $response, array $args): Response
    {
        global $Error;
        $Error = $this->container->get("flash")->getFirstMessage("error");
        return $this->runPage($request, $response, $args, "Login");
    }

    // changepassword
    public function changepassword(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ChangePassword");
    }

    // logout
    public function logout(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Logout");
    }

    // Swagger
    public function swagger(Request $request, Response $response, array $args): Response
    {
        $routeContext = RouteContext::fromRequest($request);
        $basePath = $routeContext->getBasePath();
        $lang = $this->container->get("language");
        $title = $lang->phrase("ApiTitle");
        if (!$title || $title == "ApiTitle") {
            $title = "REST API"; // Default
        }
        $data = [
            "title" => $title,
            "version" => Config("API_VERSION"),
            "basePath" => $basePath
        ];
        $view = $this->container->get("view");
        return $view->render($response, "swagger.php", $data);
    }

    // Index
    public function index(Request $request, Response $response, array $args): Response
    {
        global $Security, $USER_LEVEL_TABLES;
        $url = "";
        foreach ($USER_LEVEL_TABLES as $t) {
            if ($t[0] == "report") { // Check default table
                if ($Security->allowList($t[4] . $t[0])) {
                    $url = $t[5];
                    break;
                }
            } elseif ($url == "") {
                if ($t[5] && $Security->allowList($t[4] . $t[0])) {
                    $url = $t[5];
                }
            }
        }
        if ($url === "" && !$Security->isLoggedIn()) {
            $url = "login";
        }
        if ($url == "") {
            $error = [
                "statusCode" => "200",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => DeniedMessage()
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withHeader("Location", GetUrl("error"))->withStatus(302); // Redirect to error page
        }
        return $response->withHeader("Location", $url)->withStatus(302);
    }
}
