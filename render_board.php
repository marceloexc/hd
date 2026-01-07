<?php
enum BoardType: string {
    case DateFile = 'date';
    case ConfigFile = 'config';
    case Naked = 'naked';
}

class Board
{
	public string $title;
	public string $path;
    private string $dir_name;
	public BoardType $type;
	public int $date_unix;
	public string $description;
	public bool $visible = true;

	public function __construct(string $path, string $dir_name)
	{
		$this->path = $path;
        $this->dir_name = $dir_name;
		$this->type = $this->getBoardType();
		$this->date_unix = $this->getBoardDate();
        $this->title = $this->getBoardTitle();
		$this->description = $this->getBoardDescription();

        if ($this->type == BoardType::ConfigFile) {
            $this->visible = $this->getBoardVisibility();
        }

        if ($this->visible) {
            echo "$this->title is visible\n";
        }
	}

	private function getBoardType(): BoardType
	{
		$files = scandir($this->path);

		foreach ($files as $f) {
			if (is_file("$this->path/$f") && $f === "config.ini") {
				return BoardType::ConfigFile;
			}
		}

		foreach ($files as $f) {
			if (is_file("$this->path/$f") && $f === "date") {
				return BoardType::DateFile;
			}
		}

		return BoardType::Naked;
	}

	private function getBoardDate(): int
	{
		switch ($this->type) {
			case BoardType::ConfigFile:
				$ini_array = parse_ini_file("$this->path/config.ini", false);
				/* echo $ini_array['date']; */
				$date = strtotime($ini_array['date']);
				return $date;
			case BoardType::DateFile:
				$d_contents = file_get_contents("$this->path/date", true);
				$date = strtotime($d_contents);
				return $date;
			case BoardType::Naked:
				$date = strtotime(date ("F d Y H:i:s.", filemtime($this->path)));
				/* echo implode(',', $date); */
				return $date;
		}
	}
	
	public function getCleanPath(): string
	{
		return '/' . $this->dir_name . '/';
	}

	private function getBoardTitle(): string
	{
		switch ($this->type)
		{
			case BoardType::ConfigFile:
            $ini_array = parse_ini_file("$this->path/config.ini", false);
            $title = $ini_array['title'];
            return $title;
			default:
            return $this->dir_name;
		}
	}
	
	private function getBoardDescription(): string
		{
			switch ($this->type)
			{
				case BoardType::ConfigFile:
					$ini_array = parse_ini_file("$this->path/config.ini", false);
					if (array_key_exists('description', $ini_array)) {
						$description = $ini_array['description'];
						return $description;
					}
					else {
						return "";
					}
				default:
					return "";
			}
		}

    private function getBoardVisibility(): bool
    {
        $ini_array = parse_ini_file("$this->path/config.ini", false);
        if (array_key_exists("visible", $ini_array)) {
            $visible = $ini_array['visible'];
            return $visible;
        }
        else
        {
            return true;
        }
    }

}


class BoardListingsRenderer
{
    private string $directory;
	private array $boards = [];

    public function __construct(string $directory = "")
    {
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR);
    }

    public function render(): void
    {
        $files = scandir($this->directory);

        foreach ($files as $f) {
            if (in_array($f, ['.', '..', '.git', 'static', '.nova'])) continue;

            $full_path = $this->directory . DIRECTORY_SEPARATOR . $f;

            if (is_dir($full_path)) {
                $this->boards[] = new Board($full_path, $f);
            }
		}
        usort($this->boards, fn($b, $a) => $b->date_unix <=> $a->date_unix);
		
        foreach ($this->boards as $board) {

            if (!$board->visible) { continue; }

			$formattedDate = strtolower(date('M j, Y', $board->date_unix));

			if ($board->type == BoardType::Naked) {
				echo "<li>
            <a href=\"{$board->getCleanPath()}\">{$board->title}</a>
          </li>";
				
			} else {
				
				if ($board->description != "") {
					echo "<li>
						<a href=\"{$board->getCleanPath()}\">{$board->title}</a>
						| {$board->description}
					  </li>";
				} else {
					echo "<li>
						<a href=\"{$board->getCleanPath()}\">{$board->title}</a>
						| {$formattedDate}
					  </li>";
				}

			}
        }
	}
}

?>
