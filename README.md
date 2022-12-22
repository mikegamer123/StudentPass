<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://cdn.discordapp.com/attachments/956869907188953140/959754727887876166/unknown.png" width="400"></a></p>

<p align="center" style="font-size: 20px">
<u><b>Project for VTS Subotica and ITCluster</b></u>
</p>

## About Student Pass SU

Student pass SU is a project that has a goal of supporting Subotica in its ITSUBOTICA2030 Project which want's to bring more students to its city. With this application students will have many discounts in different gyms, cafés, and public amenities. 

## How does it work?

Student Pass SU works on an admin, worker, user, guest system, where admins have the ability to add posts/discounts to multiple companies, as well as events, while also adding and changing most of the information about companies, users, and colleges.
The users have the ability to see the discounts and enjoy in them, by logging in and using their QR Code to show to the workers. Workers can check the QR codes and also add analytic info, while guests can only view what are the available discounts and posts.

## The system behind it

Student Pass SU is divided into multiple smaller projects, the first is the API Laravel project(current), the second is React project for front-end use, and finally a React native project for mobile users.

## The system behind the API

The API will be primarily used for all front-end calls, it is based on Model, Controller and Route system, where each  model/control for the model uses the CRUD system, allowing frontend to have a simple and easy way to communicate with the DB.
<b>Also all authentication is done through laravel.</b> The auth system is based on the SANCTUM Bearer Token system.
