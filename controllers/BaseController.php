<?php

class BaseController
{

    // path format folder.filename
    // lay tu sau thu muc viewq
    const VIEW_FOLDER_NAME = 'views';
    const MODEL_FOLDER_NAME = 'models';


    protected function view($path, $data = []) //path = fontend.products.index
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        require(self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $path) . '.php'); // str_replace('.', '/', $path) =>fontend/products/index
    }

    protected function loadModel($modelPath)
    {
        require(self::MODEL_FOLDER_NAME . '/' . $modelPath . '.php');
    }

    protected function formatRespon($message,$data) {
        return json_encode([
            "message" => $message,
            "data" => $data,
        ]);
    }
}
