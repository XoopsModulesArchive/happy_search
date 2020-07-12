$Id: readme.txt,v 1.14 2008/07/09 07:51:54 ohwada Exp $

=================================================
Version: 0.60
Date:   2008-07-01
Author: Kenichi OHWADA
URL:    http://linux2.ohwada.net/
Email:  webmaster@ohwada.net
=================================================

This module search in this web site and in Google.
This is integrated xoogle module and suin's search module.

* changes *
1. show thumbnail image in album module
supported modules
- myalbum (require happy_search plugin)
- webphoto 

2. added plugin
(1) myalbum 2.88


=================================================
Version: 0.53
Date:   2008-02-16
=================================================

This module search in this web site and in Google.
This is integrated xoogle module and suin's search module.

* changes *
1. changed install script
http://linux.ohwada.jp/modules/newbb/viewtopic.php?topic_id=767&forum=8

2. used template variable xoops_module_header
http://linux.ohwada.jp/modules/newbb/viewtopic.php?topic_id=776&forum=5


=================================================
Version: 0.52
Date:   2008-01-18
=================================================

This module search in this web site and in Google.
This is integrated xoogle module and suin's search module.

* changes *
1. bug fix
(1) Only variables should be assigned by reference:


=================================================
Version: 0.51
Date:   2007-12-29
=================================================

This module search in this web site and in Google.
This is integrated xoogle module and suin's search module.

* changes *
1. bug fix
(1) not show module name
http://linux2.ohwada.net/modules/newbb/viewtopic.php?topic_id=372&forum=7


=================================================
Version: 0.50
Date:   2007-11-24
=================================================

This module search in this web site and in Google.
This is integrated xoogle module and suin's search module.

* changes *
1. supported onInstall onUpdate

2. show execution time and memory usage in each module

3. added DB table management
check config table, other tables

4. added module management

5. support PHP 5
(1) avoid to confilect PHP 5's SoapClient class
http://linux.ohwada.jp/modules/newbb/viewtopic.php?forum=10&topic_id=668
http://linux2.ohwada.net/modules/newbb/viewtopic.php?forum=7&topic_id=357

6. plugin
(1) added wordpress
convert BB code
(2) changeed smartsection
support v2.13

7. bug fix
(1) Only variables should be assigned by reference
http://linux2.ohwada.net/modules/newbb/viewtopic.php?forum=7&topic_id=348


=================================================
Version: 0.40
Date:   2007-07-01
=================================================

This module search in this web site and in Google.
This is integrated xoogle module and suin's search module.

* changes *
1. support Google Ajax Search
Get the API key on following
http://code.google.com/apis/ajaxsearch/signup.html

2. support module duplicatio
same as weblinks module

3. Block Manage, others
absorption of the difference by Major version of XOOPS
show menu to support 2.0 / 2.1 / 2.2.
judge version automatically, and reload page 10 seconds later automatically .

4. admin can set following values in admin page
(1) Main page
(2) Block

5. plugin select
admin can select plugin if there are twe or more plugins in one module

6. add plugins
(1) blusbb 1.04
(2) wfdownloads 3.10
(3) newbb 3.08

7. bug fix
(1) Undefined variable: XOOPS_LANGUAGE in block_search.php

8. multi language
(1) add Japanese UTF-8 files


* DB table *
(1) renewal module table
add first_notshow, second_show, plugin_file, plugin_func filed

* Template *
add following templates
- search_form
- google_soap
- google_ajax

* Requirement *
happy_linux module v0.90 is required


=================================================
Version: 0.30
Date:   2007-05-20
=================================================

This module search in this web site and in Google.
This is integrated xoogle module and suin's search module.

* changes *
1. Supported XoopsCube 2.1
this module works without installing system module in XC 2.1 

2. move myblocksadmin to happy_linux

3. Bugfix
(1) wrong table name

4. requirement
happy_linux module v0.80 is required


=================================================
Version: 0.20
Date:   2007-02-18
=================================================

This module search in this web site and in Google.
This is integrated xoogle module and suin's search module.

* changes *
(1) added xooops comment in the range of the search.

(2) Bugfix
(2-1) Fatal error: Call to undefined method happy_search_google::googleLangRestrictions()
(2-2) Notice [PHP]: Use of undefined constant _HAPPY_SEARCH_KEY_ERROR
(2-3) Warning: array_merge()
(2-4) Warning: usort()


=================================================
Version: 0.10
Date:   2006-12-01
=================================================

This module search in this web site and in Google.
This is integrated xoogle module and suin's search module.

This is alpha version.
From now on, the specification and implementation may change sharply. 
Even if some problems come out, only those who can do somehow personally need to use. 
Welcome the proposal of specification or the example of application, a bug report, 
a bug solution, and your hack, etc.

* extended featuer *
1. search module
(1) enhanthed fuzzy search (Jananese only)
(2) added plugin for newbb 2.01 and SmartSection 2.10 
(3) corrected plugins for newbb and news, because using short tag.
(4) support English edition

2. xoogle module
(1) sanitize the search result from google
(2) localized in Japanese in admin page (Jananese only)

3. general
(1) show to highlight the keyword
(2) use XoopsGTicket when save the configuration.

* not suceeded feature *
(1) change a module name ( directory name )
=> I will plan to support.

* suceeded feature
1. search module
search module extended the standard search feature.
(1) you can change the laying-out of a search result, because this module use the template.
(2) you can use the plugin like ryus_date freely, because this module use the template.
(3) this module shows message, if there no searchable module
(4) dont use extract(), because prevent variable pollution.
(5) easy to modify, because separating from the XOOPS core.
(6) you can select the modules to exclude to search
(7) Search [Transfer] block
This block transfer to this module automatically,
when there is a request in http://you_site/search.php.
You SHOULD use this module in all pages and all groups, 
when you want to NOT use standard search.php

(8) this module show main context. ( use plugins )
happy_search module can use same plugins as search module.

(9) Japanse fuzzy search (Jananese only)

2. xoogle module
(1) search in Google using Google SOAP Search API
(2) you MUST get Google License Key
http://code.google.com/apis/soapsearch/

* requirement *
happy_linux module is necessary.

* TODO *
(1) there is not uniformity,
because this module integrated only from search module and xoogle module
- integrate three search form
- integrate three configration page in admin page
(2) support Googole OR search
google search supports the Boolean I operator. To retrieve pages that include either word A or word B, use an uppercase OR between terms.
(3) some config variables are hard-cording.
enabale to change config variables in admin page.
(4) enable to change a module name ( directory name )

