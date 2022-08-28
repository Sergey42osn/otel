     <div>
         {{ $maildata['title'] }}!
         {{ $maildata['body'] }}<br><br>
         <a href="{{ route('customer.activate',['locale' => App::getLocale(), 'auth_token'=>$maildata['auth_token']]) }}"
            style="-webkit-text-size-adjust: none;border-radius: 4px;color: #fff;display: inline-block;overflow: hidden;text-decoration: none;margin-top: 25px;background-color: #192f47;border-bottom: 8px solid #192f47;border-left: 18px solid #192f47;border-right: 18px solid #192f47;border-top: 8px solid #192f47;">
         {{ $maildata['submit'] }}

     </div>

