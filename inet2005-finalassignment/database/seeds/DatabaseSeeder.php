<?php

use App\User;
use App\Role;
use App\Theme;
use App\Post;
use App\Like;
use App\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call('UserTableSeeder');
        $this->command->info('users table seeded!');

        $this->call('RoleTableSeeder');
        $this->command->info('roles table seeded!');

        $this->call('RoleUserTableSeeder');
        $this->command->info('role_user table seeded!');

        $this->call('ThemeTableSeeder');
        $this->command->info('themes table seeded!');

        $this->call('PostTableSeeder');
        $this->command->info('posts table seeded!');

        $this->call('LikeTableSeeder');
        $this->command->info('likes table seeded!');

        $this->call('CommentTableSeeder');
        $this->command->info('comments table seeded!');
    }
}

class UserTableSeeder extends Seeder{
    public function run()
    {
        DB::table('users')->delete();

        User::create(['name' => 'Woojin', 'email' => 'woojin@nscc.ca', 'password'=> bcrypt('123456')]);
        User::create(['name' => 'Injun', 'email' => 'injun@nscc.ca', 'password'=> bcrypt('123456')]);
        User::create(['name' => 'Claire', 'email' => 'claire@nscc.ca', 'password'=> bcrypt('123456')]);
        User::create(['name' => 'Wendy', 'email' => 'wendy@nscc.ca', 'password'=> bcrypt('123456')]);
        User::create(['name' => 'Rushan', 'email' => 'rushan@nscc.ca', 'password'=> bcrypt('123456')]);
        User::create(['name' => 'Hajun', 'email' => 'hajun@nscc.ca', 'password'=> bcrypt('123456')]);
        User::create(['name' => 'Hayoung', 'email' => 'hayoung@nscc.ca', 'password'=> bcrypt('123456')]);
    }
}

class RoleTableSeeder extends Seeder{
    public function run()
    {
        DB::table('roles')->delete();

        Role::create(['title' => 'Post Moderator']);
        Role::create(['title' => 'Theme Manager']);
        Role::create(['title' => 'User Administrator']);
    }
}

class RoleUserTableSeeder extends Seeder{
    public function run()
    {
        DB::table('role_user')->delete();

        DB::table('role_user')->insert(['role_id' => '1', 'user_id' => '1']);
        DB::table('role_user')->insert(['role_id' => '2', 'user_id' => '1']);
        DB::table('role_user')->insert(['role_id' => '3', 'user_id' => '1']);
        DB::table('role_user')->insert(['role_id' => '1', 'user_id' => '2']);
        DB::table('role_user')->insert(['role_id' => '2', 'user_id' => '3']);
        DB::table('role_user')->insert(['role_id' => '3', 'user_id' => '4']);
    }
}

class ThemeTableSeeder extends Seeder{
    public function run()
    {
        DB::table('themes')->delete();

        Theme::create(['name' => 'Bootstrap', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', 'is_default' => 1]);
        Theme::create(['name' => 'Bootswatch-Cerulean', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/cerulean/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Cosmo', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/cosmo/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Cyborg', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/cyborg/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Darkly', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/darkly/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Flatly', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/flatly/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Journal', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/journal/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Litera', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/litera/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Lumen', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/lumen/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Lux', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/lux/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Materia', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/materia/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Minty', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/minty/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Pulse', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/pulse/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Sandstone', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/sandstone/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Simplex', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/simplex/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Sketchy', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/sketchy/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Slate', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/slate/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Solar', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/solar/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Spacelab', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/spacelab/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Superhero', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/superhero/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-United', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/united/bootstrap.min.css', 'is_default' => 0]);
        Theme::create(['name' => 'Bootswatch-Yeti', 'cdn_url' => 'https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/yeti/bootstrap.min.css', 'is_default' => 0]);
    }
}

class PostTableSeeder extends Seeder{
    public function run()
    {
        DB::table('posts')->delete();

        Post::create(['title' => 'AA', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam iaculis diam ut sodales fermentum. Quisque sodales lorem vitae mauris accumsan dignissim. Fusce et molestie risus. Aliquam ultricies auctor malesuada.', 'img_url'=> 'https://robohash.org/aa', 'user_id' => '1']);
        Post::create(['title' => 'BB', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam iaculis diam ut sodales fermentum. Quisque sodales lorem vitae mauris accumsan dignissim. Fusce et molestie risus. Aliquam ultricies auctor malesuada.', 'img_url'=> 'https://robohash.org/bb', 'user_id' => '2']);
        Post::create(['title' => 'CC', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam iaculis diam ut sodales fermentum. Quisque sodales lorem vitae mauris accumsan dignissim. Fusce et molestie risus. Aliquam ultricies auctor malesuada.', 'img_url'=> 'https://robohash.org/cc', 'user_id' => '3']);
        Post::create(['title' => 'Nature Shot', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam iaculis diam ut sodales fermentum. Quisque sodales lorem vitae mauris accumsan dignissim. Fusce et molestie risus. Aliquam ultricies auctor malesuada.', 'img_url'=> 'https://robohash.org/dd', 'user_id' => '4']);
        Post::create(['title' => 'Motosport Moment', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam iaculis diam ut sodales fermentum. Quisque sodales lorem vitae mauris accumsan dignissim. Fusce et molestie risus. Aliquam ultricies auctor malesuada.', 'img_url'=> 'https://robohash.org/ee', 'user_id' => '5']);
        Post::create(['title' => 'Northern Lights', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam iaculis diam ut sodales fermentum. Quisque sodales lorem vitae mauris accumsan dignissim. Fusce et molestie risus. Aliquam ultricies auctor malesuada.', 'img_url'=> 'https://robohash.org/ff', 'user_id' => '6']);
        Post::create(['title' => 'Delicious Salmon!', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam iaculis diam ut sodales fermentum. Quisque sodales lorem vitae mauris accumsan dignissim. Fusce et molestie risus. Aliquam ultricies auctor malesuada.', 'img_url'=> 'https://robohash.org/gg', 'user_id' => '7']);
    }
}

class LikeTableSeeder extends Seeder{
    public function run()
    {
        DB::table('likes')->delete();

        Like::create(['user_id' => '1', 'post_id' => '1', 'created_by' => '1']);
        Like::create(['user_id' => '1', 'post_id' => '2', 'created_by' => '1']);
        Like::create(['user_id' => '1', 'post_id' => '3', 'created_by' => '1']);
        Like::create(['user_id' => '1', 'post_id' => '4', 'created_by' => '1']);
        Like::create(['user_id' => '1', 'post_id' => '5', 'created_by' => '1']);
        Like::create(['user_id' => '1', 'post_id' => '6', 'created_by' => '1']);
        Like::create(['user_id' => '1', 'post_id' => '7', 'created_by' => '1']);
        Like::create(['user_id' => '2', 'post_id' => '1', 'created_by' => '2']);
        Like::create(['user_id' => '3', 'post_id' => '1', 'created_by' => '3']);
        Like::create(['user_id' => '4', 'post_id' => '1', 'created_by' => '4']);
    }
}

class CommentTableSeeder extends Seeder{
    public function run()
    {
        DB::table('comments')->delete();

        Comment::create(['user_id' => '1', 'post_id' => '1', 'content' => 'AA', 'created_by' => '1', 'updated_at' => '2019-10-11 02:33:23']);
        Comment::create(['user_id' => '1', 'post_id' => '2', 'content' => 'BB', 'created_by' => '1', 'updated_at' => '2019-10-12 02:33:23']);
        Comment::create(['user_id' => '1', 'post_id' => '3', 'content' => 'CC', 'created_by' => '1', 'updated_at' => '2019-10-13 02:33:23']);
        Comment::create(['user_id' => '1', 'post_id' => '4', 'content' => 'DD', 'created_by' => '1', 'updated_at' => '2019-10-14 02:33:23']);
        Comment::create(['user_id' => '1', 'post_id' => '5', 'content' => 'EE', 'created_by' => '1', 'updated_at' => '2019-10-15 02:33:23']);
        Comment::create(['user_id' => '1', 'post_id' => '6', 'content' => 'FF', 'created_by' => '1', 'updated_at' => '2019-10-16 02:33:23']);
        Comment::create(['user_id' => '1', 'post_id' => '7', 'content' => 'GG', 'created_by' => '1', 'updated_at' => '2019-10-17 02:33:23']);
        Comment::create(['user_id' => '2', 'post_id' => '1', 'content' => 'HH', 'created_by' => '2', 'updated_at' => '2019-10-18 02:33:23']);
        Comment::create(['user_id' => '3', 'post_id' => '1', 'content' => 'II', 'created_by' => '3', 'updated_at' => '2019-10-19 02:33:23']);
        Comment::create(['user_id' => '4', 'post_id' => '1', 'content' => 'JJ', 'created_by' => '4', 'updated_at' => '2019-10-20 02:33:23']);
    }
}
