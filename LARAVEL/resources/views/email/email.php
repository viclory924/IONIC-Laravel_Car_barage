<html>
<body>
<div style="text-align: center;margin: 20px">
    <img class="img-fluid" src="{{asset('public/img/full-logo.pmg')}}" style="height: auto"></div>
<div style="width: 100%; text-align: center;font-size: 24px; color: #dc713d;">
    {{$mailInfo['body']}}
</div>
@if(isset($mailInfo['link']) && !empty($mailInfo['link']))
<div style="text-align: center;padding: 30px">
    <a href="{{env('APP_URL')}}/validate-email/{{$mailInfo['link']}}" target="_blank" class="button button-blue"
       style="">
        @lang('messages.click_me')</a>
</div>
@endif
@if(isset($mailInfo['link']) && !empty($mailInfo['body']))
<div style="text-align: center;padding: 30px; font-size: 38px;">
    {{$mailInfo['otp']}}
</div>
@endif
<br/>
<div style="width: 100%; text-align: left;font-size: 12px; color: #3e3e3e;">
    @lang('messages.signature')
</div>
</body>
</html>
