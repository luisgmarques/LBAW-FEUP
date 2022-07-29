<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Faq;

class StaticPagesController extends Controller
{
    public function showFaq()
    {
      $faqs = Faq::orderBy('id', 'desc')->get();;
      return view('static.faq', compact('faqs'));
    }

    public function addFaq()
    {
        $data = request()->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $faq = new Faq();
        $faq->create([
          'question' => $data['question'],
          'answer' => $data['answer'],
        ]);

        return redirect()->back()->with('message', 'FAQ Added!');
    }

    public function update(Faq $faq)
    {

        $data = request()->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        Faq::find($faq->id)->update($data);

        return redirect()->back()->with('message', 'FAQ Updated!');
    }

    public function showAbout()
    {
      return view('static.about');
    }

    public function showContact()
    {
      return view('static.contact');
    }
}
