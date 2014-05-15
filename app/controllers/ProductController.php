<?php

class ProductController extends BaseController
{
	public function search()
	{
		return ProductRepository::search(Input::get('q'));
	}
}
