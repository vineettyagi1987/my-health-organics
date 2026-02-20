<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactEnquiry;
use App\Mail\ContactEnquiryMail;
use App\Mail\ContactUserConfirmation;
use App\Models\Career;
class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function send(Request $request)
    {
     
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required',
    ]);
      try {

            $adminEmail = Career::where('id', 1)->value('email');

            if (!$adminEmail) {
                return back()->with('error', 'Some error found. Please try again later.');
            }

            $enquiry = ContactEnquiry::create($request->all());

            // Send email to admin
            Mail::to($adminEmail)->send(new ContactEnquiryMail($enquiry));

            // Send confirmation to user
            Mail::to($request->email)->send(new ContactUserConfirmation($enquiry));

            return back()->with('success', 'Your enquiry has been submitted successfully.');

        } catch (\Exception $e) {

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
