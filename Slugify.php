<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class slugify {



	protected $ci, $latin, $plain;

	protected $primary_key = 'id';



	public function __construct()

	{

		$this->latin = array('á', 'Ü', 'ü', 'Ş', 'ş', 'é', 'í', 'ó', 'Ö', 'ö', 'ú', 'ñ', 'ç', 'ğ', 'ü', 'à', 'è', 'ì', 'İ', 'ò', 'ù', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ç', 'Ğ', 'Ü', 'À', 'È', 'Ì', 'ı', 'Ò', 'Ù', 'ə', 'Ə',
			'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
            'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
            'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
            'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
		);

		$this->plain = array('a', 'u', 'u', 's', 's', 'e', 'i', 'o', 'o', 'o', 'u', 'n', 'c', 'g', 'u', 'a', 'e', 'i', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'N', 'C', 'g', 'U', 'A', 'E', 'I', 'i', 'O', 'U', 'e', 'E',
			'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
            'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
            'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
		);

		$this->ci =& get_instance();

	}



	public function slug($text) {



		//$ci->load->helper('url');



		$slug = str_replace($this->latin, $this->plain, $text);

		$slug = url_title($slug);

		$slug = strtolower($slug);

		return $slug;



	}



	public function slug_unique($text, $table, $column = 'slug', $id = null) {



		$slug = $this->slug($text);

		if ($this->_check_table($slug, $table, $column) > 0) {

			$i=1;

			$new_slug = $slug.'-'.$i;

			while ($this->_check_table($new_slug, $table, $column) > 0) {

				$i++;

				$new_slug = $slug.'-'.$i;

			}

			return $new_slug;

		} else return $slug;



	}



	protected function _check_table($slug, $table, $column, $id)

	{

		if ($id === NULL)

			$this->ci->db->where($this->primary_key.' !=', $id);



		$this->ci->db->where($column, $slug);

		$this->ci->db->get($table);



		return $this->ci->db->num_rows();

	}



}
