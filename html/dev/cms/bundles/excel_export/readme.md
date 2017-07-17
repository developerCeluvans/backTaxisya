# Excel Laravel Bundle

Easily export excel from PHP


Install using git make a clone of project in your bundle folder
t
```php

cd bundles
git clone git://github.com/fabianoPaula/excel_export.git excel

```

Then, place the bundle's name in your **application/bundles.php** file:

```php
<?php

return array(

	'excel' => array( 'auto' => true),
);
```


Then, place the class name in your **application/config/application.php** file:

```php

	'ExportExcel'   => 'Export\\ExportDataExcel',

```


Example:


```php

		$model = Model::all();
		
		$path = path('public')."export".DS;

		if(!is_dir($path)) mkdir($path);

		$filename = $path.'model'.date('d_m_Y').'.xlsx';

		$excel = new ExportExcel('file');
		$excel->filename = $filename;

		$excel->initialize();

		$row = array(
			"id",
								"name",
								);
			$excel->addRow($row);

		foreach($paroquias as $object){
			$row = array(
			$object->id,
			$object->name,
			);
			$excel->addRow($row);
		}

		$excel->finalize();

		return Response::download($filename);
```


