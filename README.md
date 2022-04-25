# Log Parser
## Installation

    git clone git@github.com:Sithell/log-parser.git
    cd log-parser
    composer install

## Quick Start

    $ bin/console parse --silent <filename>
    {
        "views": 16,
        "urls": 5,
        "traffic": 187990,
        "statusCodes": {
            "200": 14,
            "301": 2
        },
        "crawlers": {
            "Google": 2,
            "Bing": 0,
            "Baidu": 0,
            "Yandex": 0
        }
    }

## Usage

    Usage:
      bin/console parse [options] [--] <path>

    Arguments:
      path                      Pass the path to log file.

    Options:
      -s, --silent|--no-silent  Do not show UI (progress bar).
      -h, --help                Display help for the given command. When no command is given display help for the list command
      -q, --quiet               Do not output any message
      -V, --version             Display this application version
          --ansi|--no-ansi      Force (or disable --no-ansi) ANSI output
      -n, --no-interaction      Do not ask any interactive question
      -v|vv|vvv, --verbose      Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

    Help:
      Prints number of views, number of unique urls, traffic volume, number of lines, number of requests from search engines, response codes.

