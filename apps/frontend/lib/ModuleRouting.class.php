<?php
/**
 * Слушает событие 'routing.load_configuration' и добавляет роуты отдельных модулей.
 */
class ModuleRouting {
    /**
     * Слушает событие.
     *
     * @static
     * @param sfEvent $event
     * @return void
     */
    public static function listenToRoutingLoadConfigurationEvent(sfEvent $event) {
        $routing = $event->getSubject();

        $handler = new sfRoutingConfigHandler();
        $routes = array_merge($handler->evaluate(self::getModuleRoutes()), $routing->getRoutes());

        $routing->clearRoutes();
        $routing->setRoutes($routes);
    }

    /**
     * Загружает роуты и отдает скомпилированные роуты модулей.
     *
     * @static
     * @return array
     */
    protected static function getModuleRoutes() {
        $modulesDirectory = realpath(dirname(__FILE__) . '/../modules');
        $directoryHandler = opendir($modulesDirectory);
        $configFiles = array();

        while ($module = readdir($directoryHandler)) {
            if ($module == '.' || $module == '..') {
                continue;
            }

            $config = sprintf('%s/%s/config/routing.yml', $modulesDirectory, $module);
            
            if (file_exists($config) && is_readable($config)) {
                $configFiles[] = $config;
            }
        }

        return $configFiles;
    }
}