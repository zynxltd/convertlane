<x-mail::message>
# Contact form submission

**Name:** {{ $contact->name }}  
**Email:** {{ $contact->email }}  
**Subject:** {{ $contact->subject }}

---

## Message

{{ $contact->message }}

---

Reply directly to this email to respond to {{ $contact->name }}.

</x-mail::message>
