<?php

namespace MgTest\controlers;

/**
 * This is the main controller class
 * it loads the view and passes in the model data
 *
 * Class MainController
 */
class MainController implements Controller
{
    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var string
     */
    private $partialPath;

    /**
     * @var string;
     */
    private $modelNamespace = 'MgTest\\src\\models';

    /**
     * Set some basic paths for the views and partials
     * constructor
     */
    public function __construct()
    {
        $this->viewPath     = AWEOSOME_TABLE_DEFINED['PLUGIN_DIR'] . '/src/views/';
        $this->partialPath  = AWEOSOME_TABLE_DEFINED['PLUGIN_DIR'] . '/src/views/partials/';
    }

    /**
     * Loads the model if it exists and returns it to the controller or view
     * 
     * @param string $modelName
     * @param array $param
     * @return mixed
     */
    public function model($modelName = '', $param = [])
    {
        $class = $this->modelNamespace.$modelName;
        if (class_exists($class)) {
            $obj = new $class();

            if (empty($param)) {
                return $obj;
            } else {
                //__invoke from the model
                return $obj($param);
            }
        }
        return false;
    }

    /**
     * Loads the view if it exists and returns it to the controller 
     * @param $viewName
     * @param array $data
     * @return MainController
     */
    public function view($viewName, $data = [])
    {
        echo $this->verifyLoading($this->viewPath, $viewName, $data);
        return $this;
    }

    /**
     * Checks if a file exists and requires it
     * 
     * @param $path
     * @param $viewName
     * @param array $data | is being injected and not used inside?? think again!!
     * All the code being required will see $data ... 🤺
     * @return bool
     *
     * @throws Exception
     */
    public function verifyLoading($path, $viewName, $data = [])
    {
        $viewFile = $path . (string)$viewName . '.php';
        if (file_exists($viewFile)) {
            ob_start();
            include $viewFile;
            return ob_get_clean();
        }
        
        throw new \Exception('Partial view file ' . $path . $viewName . ' not found');
    }
}