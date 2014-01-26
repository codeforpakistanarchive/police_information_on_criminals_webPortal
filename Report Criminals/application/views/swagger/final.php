<?php

$allvalue = array(
	"apiVersion" => "1.0.0",
	"swaggerVersion" => "1.2",
	"apis" => array(
		array(
		"path" => "/user",
		"description" => "Operations about user"
		),
		array(
		"path" => "/pet",
		"description" => "Operations about pets"
		)
	),
	"authorizations" => array(
		"oauth2" => array(
			"type" => "oauth2",
			"scopes" => array("PUBLIC"),
			"grantTypes"=> array(
				"implicit" => array(
					"loginEndpoint" => array(
						"url" => "http://petstore.swagger.wordnik.com/api/oauth/dialog"
					),
					"tokenName" => "access_code"
				),
				"authorization_code" => array(
					"tokenRequestEndpoint" => array(
						"url" => "http://petstore.swagger.wordnik.com/api/oauth/requestToken",
						"clientIdName" => "client_id",
						"clientSecretName" =>"client_secret"
					),
					"tokenEndpoint" => array(
						"url" => "http://petstore.swagger.wordnik.com/api/oauth/token",
						"tokenName" => "access_code"
					)
				)
			)
		),
		"apiKey" => array(
			"type" => "apiKey",
			"keyName" => "api_key",
			"passAs" => "header"
		),
		"basicAuth" => array(
			"type" => "basicAuth"
		)
	
	),
	"info" => array(
		"title" => "Swagger Sample App",
		"description" => "This is a sample server Petstore server.  You can find out more about Swagger \n    at <a href=\"http://swagger.wordnik.com\">http://swagger.wordnik.com</a> or on irc.freenode.net, #swagger.  For this sample,\n    you can use the api key \"special-key\" to test the authorization filters",
		"termsOfServiceUrl" => "http://helloreverb.com/terms/",
		"contact" => "apiteam@wordnik.com",
		"license" => "Apache 2.0",
		"licenseUrl" => "http://www.apache.org/licenses/LICENSE-2.0.html"
	)
	);
	header('Access-Control-Allow-Origin: *');
	echo json_encode($allvalue);