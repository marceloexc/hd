#!/usr/bin/env python3
import argparse
import sys
from pathlib import Path
import shutil

def create_new_board(args):
        
    hd_dir = Path(sys.argv[0]).resolve().parent
    BOARD_ORIGINAL_CSS_PATH = hd_dir / "static/board.css"
    CONTENT_PATH = hd_dir / "content/"
    board_name = args.name
    
    if " " in args.name:
        raise ValueError("no spaces!!!")

    for directory in CONTENT_PATH.iterdir():
        if directory.name == args.name:
            raise Exception("already found a board with that name!")

    board_path = CONTENT_PATH / board_name
    board_path.mkdir(exist_ok=True)

    # copy the css file(s)

    board_css_dest = board_path / "board.css"
    shutil.copy(BOARD_ORIGINAL_CSS_PATH, board_css_dest)

    # create the config.ini file
    
    from datetime import datetime
    import configparser

    board_config_file_destination = board_path / "config.ini"
    with open(board_config_file_destination, 'w') as configfile:
        config = configparser.ConfigParser()
        config['board'] = {
            'title': f'"{args.name}"',
            'date': f'"{datetime.now()}"'
        }
        config.write(configfile)

    ## creating the org file

    board_org_file_dst = board_path / f"{board_name}.org"
    # don't know of a better way of doing this
    with open(board_org_file_dst, 'w') as file:
        org_content = f"""\
#+TITLE: {board_name}
#+AUTHOR: Marcelo Mendez
#+EXPORT_FILE_NAME: index.html
#+OPTIONS: toc:nil num:nil title:nil date:nil html-postamble:nil html5-fancy:t
#+HTML_DOCTYPE: html5
#+HTML_HEAD: <link rel="stylesheet" href="board.css" type="text/css">
        """
        file.write(org_content)
        file.close()

    print("done")

def main():
    
    parser = argparse.ArgumentParser(prog="hd.py")
    subparsers = parser.add_subparsers(dest="Command", required=True)

    creator_parser = subparsers.add_parser("new", help="create new board. requires board name")
    creator_parser.add_argument("name", help="board name")
    creator_parser.set_defaults(func=create_new_board)
    args = parser.parse_args()
    args.func(args)
    

if __name__ == "__main__":
    main()
