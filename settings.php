<?php
class handle
{
    protected $file;
    public function __construct($file)
    {
        $this->file = $file;
    }
    public function updateOrInsert(array $user)
    {
        if (!file_exists($this->file))
        {
            fopen($this->file, "w");
        }
        $output = [];
        $userName = key($user);
        $fn = new SplFileObject($this->file, 'r+');
        $hasExistUser = false;
        while (!$fn->eof())
        {
            $line = str_replace(PHP_EOL, '', $fn->fgets());
            if (!$line)
            {
                continue;
            }
            $data = json_decode(trim($line) , true);
            $logUserName = key($data);
            if ($userName === $logUserName)
            {
                $hasExistUser = true;
                $line = json_encode($user);
            }
            $output[] = $line;
        }
        if (!$hasExistUser)
        {
            $output[] = json_encode($user);
        }
        file_put_contents($this->file, implode(PHP_EOL, $output));
    }
}
$file = 'settings.json';
var_dump($_POST);
// user data
$user = $_POST['prefs_json'];
$handle = new handle($file);
$handle->updateOrInsert($user);
?>
