<div>
    <h2>{{$subject}}</h2>
    @foreach($mailMessage as $message)
        <p>First Name = {{$message['first_name']}}</p>
        <p>Last Name = {{$message['last_name']}}</p>
        <p>Email = {{$message['email']}}</p>
        <p>Hobbies = {{json_decode($message['hobbies'])}}</p>
        <p>gender = {{$message['gender']}}</p>
    @endforeach
</div>
