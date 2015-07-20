<?php

	/**
	 * Class Share
	 * A Simple DTO to share data across wordpress template file
	 */
	class Share {

		/**
		 * @var
		 */
		public static $data;

		/**
		 * @param mixed $data
		 */
		public static function setData( $data )
		{
			self::$data = $data;
		}

		/**
		 * @return mixed
		 */
		public static function getData()
		{
			return self::$data;
		}

	}