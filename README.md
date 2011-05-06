# CakeSmarty - Plugin to integrate CakePHP 1.3 and Smarty 3

CakeSmarty is a plugin for CakePHP, which enables Smarty based view system.

## License

LGPL License.

## Install

	$ git submodule add git://github.com/kanshin/CakeSmarty.git plugins/smarty

* Just put the directory into the plugin directory (ROOT/plugins or ROOT/app/plugins).
* The name of directory is whatever you like. "smarty" is recommended.
* Smarty library is bundled in the package.

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

