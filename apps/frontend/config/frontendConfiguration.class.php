<?php

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
      $this->dispatcher->connect('routing.load_configuration', array('ModuleRouting', 'listenToRoutingLoadConfigurationEvent'));
  }
}
