## Introduction

Sometimes you need to have tracepoints inside your procedures, without breaking it with dumping some data. 

Sometimes it's not very easy to use `dd()` or similar ways to see what's going on.

`Chalk` will utilize Laravel caching tools to make this work like a breeze. 

## Install

```bash
composer require dutymess/chalk
```

## Simple Usage

⚠️ For security reasons, `Chalk` works when and only when the application is in the debug mode. 

### In the Tracepoint

Easily store what you want to monitor later. A timestamp is added automatically.

```php
chalk()->write($anything);
```

where

* `$anything` is a variable of any type, but is more efficient if provided in the type of string.

## In a Safe Place

A safe place is somewhere out of your procedure. This could be a blank testing page, or simply the `tinker` tool in the terminal console. 

Read stored data, ordered by the timestamp. 

```php
chalk()->read();
```

An array of stored data, together with the carbon timestamps will be returned in the form of an array. 

### Example

❗️ To be Added ❗️

## Advanced Usage

### Custom Stacks

Sometimes, there are lots of things to be traced. Putting them all in a single array would make it difficult to track the changes. 

To solve this problem, you may specify a custom stack name when calling the `chalk()` helper.

```php
chalk('jafar')->write('something');
chalk('jafar')->read();
```

### Clearing Data

You may want to reset the current data and start clean at your first tracepoint. 

```php
chalk()->clear();
```

Of course, you may clear your data stored in the custom stacks as well.

```php
chalk('jafar')->clear();
```

In some odd cases, you may want to clear all the stored data in all available stacks. 

```php
chalk()->clearAllStacks();
```

### Custom Expire Time

By default, `Chalk()` stores data in the cache for just ten minutes. This should be pretty enough to see what's going on.

However, you may override this default behavior by setting a custom timeout.

```php
chalk()::setTimeout($minutes);
```

### 
