<?php
/**
 * @package    apostrophePlugin
 * @subpackage    embedService
 * @author     P'unk Avenue <apostrophe@punkave.com>
 */
class aPicasa extends aEmbedService
{
  private static $fetched = false;
  private static $info = array();
  private static $photos = array();
  protected $features = array( 'thumbnail', 'browseUser');

  /**
   * DOCUMENT ME
   * @param mixed $feature
   * @return mixed
   */
  public function supports($feature)
  {
    return in_array($feature, $this->features);
  }


  /**
   * Returns just enough information to verify you found the right user. This is not meant to be
   * a fancy presentation that end users see, it's for admins adding a linked account. Please don't
   * introduce English into the result here as we'd have to i18n it
   * @param mixed $user
   * @return mixed
   */
  public function getUserInfo($user)
  {
    if(!self::$fetched) $this->fetchPicasa($user);
    return self::$info;
  }


  public function fetchPicasa($user)
  {

    $xml = @simplexml_load_file('http://picasaweb.google.com/data/feed/base/user/' . urlencode($user));
    if (!$xml) { return false;}

    self::$info['name'] = (string) $xml->author->name;
    self::$info['description'] = sprintf('<a href="%s" target="_blank">%s</a>',
                            (string) $xml->author->uri,(string) $xml->title);


    foreach ($xml->entry as $album)
    {
      $xml2 = @simplexml_load_file((string) $album->link['href']);
      if (!$xml2) { continue;}
      foreach ($xml2->entry as $entry)
      {
        self::$photos[]= array(
                    'id' => (string) $entry->id,
                    'title' => (string) $entry->title,
                    'url' => (string) $entry->id
                    );
     }
    }    
  
    self::$fetched = true;
  
  }


  public function browseUser($user, $page = 1, $perPage = 50)
  {
    if(!self::$fetched) $this->fetchPicasa($user);
    $results = array_slice(self::$photos, ($page-1)*$perPage, $perPage);    
    return array('total' => count(self::$photos), 'results' => $results);
  }

  
  public function getInfo($id)
  {
    $xml = @simplexml_load_file($id);
    if (!$xml) { return false;}
    $namespaces = $xml->getNameSpaces(true);
    $media = $xml->children($namespaces['media']);
    $result = array('title' => (string) $media->group->title, 
                    'description' => (string) $media->group->description, 
                    'tags' => (string) $media->group->keywords, 
                    'id' => (string) $id, 
                    'url' => (string) $id, 
                    'image_url' => (string) $media->group->content->attributes()->url, 
                    'credit' => (string) $media->group->credit);

    return $result;
  }


  public function embed($id, $width, $height, $title = '', $wmode = 'opaque', $autoplay = false)
  {
    $photo = $this->getInfo($id);
    $title = $photo['title'];
    $url = $photo['url'];
return <<<EOM
<img alt="$title" width="$width" height="$height" src="$url" / >
EOM
;
  }
  
  public function getThumbnail($id)
  {
    $photo = $this->getInfo($id);
    return $photo['image_url'];
  }
  
  public function getIdFromUrl($url)
  {
    return $url;
  }

  public function getIdFromEmbed($url)
  {
    return $this->getIdFromUrl($url);
  }

  public function getUrlFromId($id)
  {
    return $id;
  }

  public function getName()
  {
    return 'Picasa';
  }
}
