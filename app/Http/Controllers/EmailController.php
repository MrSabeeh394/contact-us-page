<?php

namespace App\Http\Controllers;

use App\Mail\sendemail;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class EmailController extends Controller
{
    public function viewContactUs()
    {
        return view('contactus');
    }
    public function submitContactUs(Request $request)
    {
        // dd($request->file());

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|min:5|max:100',
            'message' => 'required|min:10|max:255',
            'attachment' => 'required|mimes:pdf,png,jpeg,jpg|max:2048',

        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        if ($request->hasFile('attachment')) 
        {
            $fileName = time() . '.' . $request->file('attachment')->extension();
            // $attachmentPath = $request->file(key: 'attachment')->move(public_path('uploads'), $fileName);
            
            $manager = new ImageManager(new Driver());
            $attachment = $manager->read($request->attachment);

            $attachment->resize(500, height: 500);
            $attachment->toPng()->save(public_path('uploads/' . $fileName));

            // Save to the database
            $contact = new ContactUs();
            $contact->name = $request->input('name');
            $contact->email = $request->input('email');
            $contact->subject = $request->input('subject');
            $contact->message = $request->input('message');


            // Store the attachment path (relative) in the database
            $contact->attachment = $fileName;
            $contact->save(); // Save the contact entry
        }


        return response()->json([
            'success' => true,
            'message' => "Thanks for contacting us. We will get back to you shortly.",
        ], 200);

        if ($contact) {
            return back()->with('success', "Thanks for contacting us. We will get back to you shortly.");
        } else {
            return back()->with('error', "Try again, Unable to submit the form");
        }
    }
}
