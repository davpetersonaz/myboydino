<?php
class Pictures{

	/**
	 * scans all the picture directories and verifies thumbnails exist
	 */
	public function __construct(){
		$this->orig_pics_filenames = scandir(self::PICS_DIR);
		$this->orig_pics_filenames = array_diff($this->orig_pics_filenames, array('.', '..', 'best', 'feat', 'home'));
		$this->thumbs_filenames = scandir(self::PIC_THUMBS_DIR);
		$this->thumbs_filenames = array_diff($this->thumbs_filenames, array('.', '..', 'best', 'home'));

		$this->best_pics_filenames = scandir(self::BEST_PICS_DIR);
		$this->best_pics_filenames = array_diff($this->best_pics_filenames, array('.', '..'));
		$this->best_thumbs_filenames = scandir(self::BEST_THUMBS_DIR);
		$this->best_thumbs_filenames = array_diff($this->best_thumbs_filenames, array('.', '..'));

		$this->feat_pics_filenames = scandir(self::FEAT_PICS_DIR);
		$this->feat_pics_filenames = array_diff($this->feat_pics_filenames, array('.', '..'));

		$this->home_pics_filenames = scandir(self::HOME_PICS_DIR);
		$this->home_pics_filenames = array_diff($this->home_pics_filenames, array('.', '..'));
		$this->home_thumbs_filenames = scandir(self::HOME_THUMBS_DIR);
		$this->home_thumbs_filenames = array_diff($this->home_thumbs_filenames, array('.', '..'));
	}

	/**
	 * crop the image to given proportions, then resize it to given height/width, and save it to given directory
	 * @param string $filename name of the image file
	 * @param string $dir path of the image file directory
	 * @param int $desiredWidthProportion the width proportion for the final image
	 * @param int $desiredHeightProportion the height proportion for the final image
	 * @param int $thumbWidth the width of the final image
	 * @param int $thumbHeight the height of the final image
	 * @param string $thumbDir path of the final image directory
	 */
	//ex) createThumbnail('somefile.jpg', self::PICS_DIR, 9, 16, self::BEST_THUMB_W, self::BEST_THUMB_H, self::THUMBS_DIR);
	public function createThumbnail($filename, $dir, $desiredWidthProportion, $desiredHeightProportion, $thumbWidth, $thumbHeight, $thumbDir){
		try{

			//first, crop it square by the dimensions of the shortest edge, with equal amounts of the longer edge chopped off.
			$imagick = new Imagick($dir.$filename);
			$width = $imagick->getimagewidth();
			$height = $imagick->getimageheight();
			$proportion = $height / $width;
			if($proportion < ($desiredHeightProportion / $desiredWidthProportion)){
				//landscape
				$desired_width = $desiredWidthProportion * $height / $desiredHeightProportion;
				$crop_each_side_by = ($width - $desired_width) / 2;
				$top_left_corner_x = ($width - $crop_each_side_by - $desired_width);
				$top_left_corner_y = 0;
				if(!$imagick->cropimage($desired_width, $height, $top_left_corner_x, $top_left_corner_y)){
					//apparently cropimage can return false sometimes, even though the image is cropped successfully.
				}
			}elseif($proportion > ($desiredHeightProportion / $desiredWidthProportion)){
				//portrait
				$desired_height = $desiredHeightProportion * $width / $desiredWidthProportion;
				$crop_top_bottom_by = ($height - $desired_height) / 2;
				$top_left_corner_x = 0;
				$top_left_corner_y = ($height - $crop_top_bottom_by - $desired_height);
				if($imagick->cropimage($width, $desired_height, $top_left_corner_x, $top_left_corner_y)){
					//apparently cropimage can return false sometimes, even though the image is cropped successfully.
				}
			}else{
				//it is the proper proportions already
			}

			//resize it
			if(!$imagick->scaleimage($thumbWidth, $thumbHeight)){
				logDebug('FAILURE resizing thumbnail['.$thumbWidth.'x'.$thumbHeight.']: '.$filename);
			}

			//save it
			if(!$imagick->writeimage($thumbDir.$filename)){
				logDebug('FAILURE writing thumbnail: '.$thumbDir.$filename);
			}

		}catch(Exception $e){
			logDebug('EXCEPTION creating thumbnail: '.var_export($e, true));
		}
	}

	/**
	 * returns all the pictures in chronological order
	 * @return array all pictures in chronological order
	 */
	public function getPicturesChronological(){
		sort($this->orig_pics_filenames);
		return $this->orig_pics_filenames;
	}

	/**
	 * returns all the pictures after shuffling them
	 * @return array all pictures in random order
	 */
	public function getPicturesShuffled(){
		shuffle($this->orig_pics_filenames);
		return $this->orig_pics_filenames;
	}

	/**
	 * returns an alphabetical list of all the pictures
	 * @return array all pictures in alphabetical order
	 */
	public function getPicturesAlphabetical(){
		$newArray = array();
		foreach($this->orig_pics_filenames as $filename){
			//change YYYYMMDD-filename.jpg to filename.jpg-YYYYMMDD
			$newArray[] = substr($filename, 9).'-'.substr($filename, 0, 8);
		}
		sort($newArray);
		$newerArray = array();
		foreach($newArray as $filename){
			//revert filename.jpg-YYYYMMDD to YYYYMMDD-filename.jpg
			$newerArray[] = substr($filename, -8).'-'.substr($filename, 0, -9);
		}
		return $newerArray;
	}

	/**
	 * returns all the featured image filenames in a random array
	 * @return array featured image filenames
	 */
	public function getBestPics(){
		shuffle($this->best_pics_filenames);
		return $this->best_pics_filenames;
	}

	/**
	 * returns all the featured image filenames in a random array
	 * @return array featured image filenames
	 */
	public function getFeaturedPics(){
		shuffle($this->feat_pics_filenames);
		return $this->feat_pics_filenames;
	}

	/**
	 * returns a random pic for the home-page
	 * @return string filename of a random home-page pic to display
	 */
	public function getHomePic(){
		$homepics = $this->getHomePics();
		shuffle($homepics);
		$rand_key = array_rand($homepics, 1);
		return $homepics[$rand_key];
	}

	/**
	 * returns a random pic for the home-page
	 * @return string filename of a random home-page pic to display
	 */
	public function getHomePics(){
		return $this->home_pics_filenames;
	}

	const PICS_URL = '/images/pics/';
	const THUMBS_URL = '/images/thumbs/';

	const PICS_DIR = REAL_PATH.'www'.self::PICS_URL;
	const PIC_THUMBS_URL = self::THUMBS_URL.'pics1x1/';
	const PIC_THUMBS_DIR = REAL_PATH.'www'.self::THUMBS_URL.'pics1x1/';
	const THUMB_SIZE = 350;

	const BEST_PATH = 'best';
//	const BEST_PICS_URL = self::PICS_URL.self::BEST_PATH.'/';
	const BEST_PICS_DIR = self::PICS_DIR.self::BEST_PATH.'/';
	const BEST_THUMBS_URL = self::THUMBS_URL.self::BEST_PATH.'16x9/';
	const BEST_THUMBS_DIR = REAL_PATH.'www'.self::THUMBS_URL.self::BEST_PATH.'16x9/';
	const BEST_THUMB_W = 608;
	const BEST_THUMB_H = 360;

	const FEAT_PATH = 'feat/';
	const FEAT_PICS_URL = self::PICS_URL.self::FEAT_PATH;
	const FEAT_PICS_DIR = self::PICS_DIR.self::FEAT_PATH;
	//no thumbs for featured pics, they are already cropped to the proper proportions

	const HOME_PATH = 'home';
//	const HOME_PICS_URL = self::PICS_URL.self::HOME_PATH.'/';
	const HOME_PICS_DIR = self::PICS_DIR.self::HOME_PATH.'/';
	const HOME_THUMBS_URL = self::THUMBS_URL.self::HOME_PATH.'4x3/';
	const HOME_THUMBS_DIR = REAL_PATH.'www'.self::THUMBS_URL.self::HOME_PATH.'4x3/';
	const HOME_THUMB_W = 800;
	const HOME_THUMB_H = 600;

	private $orig_pics_filenames = [];
	private $best_pics_filenames = [];
	private $feat_pics_filenames = [];
	private $home_pics_filenames = [];
	private $thumbs_filenames = [];
	private $best_thumbs_filenames = [];
}