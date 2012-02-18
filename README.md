# CakeSmarty - Plugin to integrate CakePHP 2.0 and Smarty 3

CakeSmarty is a plugin for CakePHP, which enables Smarty based view system.

LGPL License.

## Install

	$ git submodule add git://github.com/shimotori/CakeSmarty.git plugins/Smarty

* Just put the directory into the plugin directory (ROOT/plugins or ROOT/app/plugins).
* The name of directory is whatever you like. "Smarty" is recommended.
* Smarty library is bundled in the package ("Vendor" directory). You need to
  rename the directory of Smarty package, which you want to use, to "smarty".
* Smarty config_dir is app/View/Smarty.

## How to use

In your AppController, add:

	public $view = 'Smarty.Smarty';

The SmartyView is placed in *plugins/Smarty/View*, the first part is the name of
plugin itself and the second part is the name of View system. If you change the
name of plugin, change the first part as such.

Template files should be placed in View directory, just as you used to do.
Default extension is .tpl, which you can change.

If it cannot find smarty view file, and there are CakePHP template file (.ctp), 
it delegate the work to default view renderer. It means you can mix Smarty View 
Template and default View Template.

Because SmartyView is inherited from ThemeView, you can safely use theme with 
Smarty.


## Smarty tags and modifiers for CakePHP

CakeSmarty comes with many new Smarty tags (functions and blocks). Many of them 
are ported from CakePHP helpers.

Almost all of them are just wrapper code. It uses helpers and Cake code internally.


### From HtmlHelper

* {link ...}...{/link} - $this->Html->link(...)

### From FormHelper

* {form}...{form} - $this->Form->create(...) ... $this->Form->end()
* {input} - $this->Form->input(...)
* {checkbox} - $this->Form->checkbox(...)
* {radio} - $this->Form->radio(...)
* {password} - $this->Form->password(...)
* {secure} - $this->Form->secure(...)
* {text} - $this->Form->text(...)
* {textarea} - $this->Form->textarea(...)
* {select} - $this->Form->select(...)
* {file} - $this->Form->file(...)
* {image} - $this->Form->image(...)
* {submit} - $this->Form->submit(...)
* {button} - $this->Form->button(...)
* {datetime_input} - $this->Form->datetime_input(...)
* {year} - $this->Form->year(...)
* {month} - $this->Form->month(...)
* {day} - $this->Form->day(...)
* {hour} - $this->Form->hour(...)
* {minute} - $this->Form->minute(...)
* {meridian} - $this->Form->meridian(...)
* {hidden} - $this->Form->hidden(...)
* {inputs} - $this->Form->inputs(...)
* {isfielderror} - $this->Form->isfielderror(...)
* {error} - $this->Form->error(...)
* {label} - $this->Form->label(...)

### Router

* {url} - Router::url(...)
* {querystring} - Router::querystring(...)

### View method

* {title}...{/title} - set title_for_layout
* {head}...{/head} - add contents to <head>. $view->addScript()

### Modifiers

* date - format the date using date() or strftime(). If '%' character is found in the format string, 
	strftime() is used. Otherwise date() is used. You can specify default format in *views/config/default.in*.

* t - translate a text using __().

