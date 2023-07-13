<?php

namespace App\Http\Controllers;

use App\Models\TextWidget;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteController extends Controller
{
    public function about(): View
    {
        $widget = TextWidget::getFull('about-us');
        if (!$widget){
            throw new NotFoundHttpException();
        }
        return view('page.about' , compact('widget'));
    }
}
