# Minimum Kindle Book Generator
A web GUI of generating a simple Kindle Book.

## Screenshot
![screenshot](http://mitsuakikawamorita.com/software/MKBG/MKBG_screen_shot.png)

## Generated Book
- [sample generated book](http://mitsuakikawamorita.com/software/MKBG/the_great_gatsby_sample.mobi)

## Requirements
- Available on Linux (Also available on MacOS, but need a kindlegen for MacOS)
- httpd(Apache, Nginx, lighttd, etc)
- PHP(> 5.3)
- PHP plugins, GD, mbstring
- [KindleGen v2.8 for Linux 2.6 i386](http://www.amazon.com/gp/feature.html?ie=UTF8&docId=1000765211)
- [ipagui-mona.ttf](http://www.geocities.jp/ipa_mona/opfc-ModuleHP-1.1.1_withIPAMonaFonts-1.0.8.tar.gz)

## Licence
- Public Domain ( Contributions are really welcome:) )

## Notes
I'd like to host this to my server for everybody, but according to kindlegen's licence, to set kindlegen via network is forbidden. So please use it on your own machine for only you.

## ToDo
- HTML tags available
- Markdown and Textile
- Users can upload their own picture as a cover

## How to install and run

### CentOS / ScientficLinux / Amazon Linux
	$ yum install php php-mbstring php-mysql php-mcrypt php-gd php-devel php-pear php-pecl-apc httpd git -y
	$ cd /var/lib/
	$ git clone git://github.com/kawa-/MinimumKindleBookGenerator.git
	$ cd MinimumKindleBookGenerator/
	$ mkdir kindlegen_lib
	$ cd kindlegen_lib/
	$ wget http://s3.amazonaws.com/kindlegen/kindlegen_linux_2.6_i386_v2_8.tar.gz
	$ tar -zxvf kindlegen_linux_2.6_i386_v2_8.tar.gz
	$ cp kindlegen ./../
	$ cd ..
	$ wget http://www.geocities.jp/ipa_mona/opfc-ModuleHP-1.1.1_withIPAMonaFonts-1.0.8.tar.gz
	$ tar -zxvf opfc-ModuleHP-1.1.1_withIPAMonaFonts-1.0.8.tar.gz
	$ cp opfc-ModuleHP-1.1.1_withIPAMonaFonts-1.0.8/fonts/ipagui-mona.ttf ./
	$ rm -rf opfc-ModuleHP-1.1.1_withIPAMonaFonts-1.0.8* kindlegen_lib
	$ chown -R apache:apache /var/lib/MinimumKindleBookGenerator
	$ ln -s /var/lib/MinimumKindleBookGenerator /var/www/html/MKBG
	$ cp Lib/php.ini /etc/php.ini
	$ service httpd restart
- And access to http://yourdomain/MKBG/.
- In the webpage, firstly click "Set example".
- Next, "Generate Book".
- In the end, downloadlink and log will appear.
