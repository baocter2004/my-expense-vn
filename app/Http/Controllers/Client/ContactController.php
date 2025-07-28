<?php

namespace App\Http\Controllers\Client;

use App\Consts\ContactConst;
use App\Http\Controllers\Controller;
use App\Services\Client\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(protected ContactService $contactService) {}
    public function showFormContact()
    {
        $contacts = ContactConst::SUBJECTS;
        return view('client.pages.contact', compact('contacts'));
    }

    public function submit(Request $request)
    {
        $params = $request->validate([
            'last_name' => 'required|string|max:100',
            'first_name' => 'required|string|max:100',
            'email' => 'required|email|nullable',
            'message' => 'required|string',
            'subscribe' => 'nullable|integer',
        ], [], [
            'message' => 'Tin nhắn',
            'subscribe' => 'Đăng ký',
        ]);

        $result = $this->contactService->submitContact($params);

        if ($result['success']) {
            return redirect()->route('client.showFormContact')
                ->with('success', $result['message']);
        } else {
            return back()->withInput()->with('error', $result['message']);
        }
    }
}
