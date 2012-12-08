<?php

	/**
	 * A collection of useful function
	 * @author danielmason
	 */

	class Tools {
		
		/**
		 * Turn an array into an object
		 * @param array $array
		 * @param boolean $recursive
		 * @return stdClass
		 */
		public static function arrayToObject(array $array, $recursive = false) {
			$object = new stdClass();
			foreach($array as $field => $value) {
				if($recursive && is_array($value))
					$object->$field = static::arrayToObject($value, $recursive);
				else
					$object->$field = $value;
			}
			return $object;
		}
		
		public static function randomString($length, $caseSensetive = false) {
			
			$chars = '0,1,2,3,4,5,6,7,8,9,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z';
			if($caseSensetive)
				$chars .= ',A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z';
			$chars = explode(',', $chars);
			$max = count($chars) - 1;			
			
			$string = '';
			for($i = 0; $i < $length; $i++) {
				$string .= $chars[mt_rand(0, $max)];
			}
			return $string;
		}
		
	}