<?php
namespace FlightControl;

interface IController{

	public function getView();
	public function getData();
	public function start();

}