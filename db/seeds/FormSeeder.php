<?php

use Phinx\Seed\AbstractSeed;

class FormSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
		// Truncate so this can be rebuilt in demo/dev environments
		$this->execute('TRUNCATE TABLE forms RESTART IDENTITY CASCADE');
		// Truncate so this can be rebuilt in demo/dev environments

        $formData = [
                        [
                            'form_id' => 1,
                            'name' => 'OD Form',
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. At risus viverra adipiscing at in tellus integer feugiat. Quis vel eros donec ac odio tempor. Mauris a diam maecenas sed enim ut sem viverra aliquet. Auctor elit sed vulputate mi sit. Vitae auctor eu augue ut lectus arcu bibendum at varius. Tempus iaculis urna id volutpat. Consectetur libero id faucibus nisl tincidunt eget nullam non. Aliquam purus sit amet luctus venenatis lectus magna fringilla urna. Id semper risus in hendrerit gravida rutrum quisque. Orci phasellus egestas tellus rutrum tellus pellentesque eu. Amet cursus sit amet dictum sit amet justo donec. Volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque. Neque laoreet suspendisse interdum consectetur libero id faucibus nisl. Lorem dolor sed viverra ipsum. Bibendum arcu vitae elementum curabitur vitae. Ullamcorper velit sed ullamcorper morbi.',
                            'template_url' => 'od_form',
                            'visibility' => true,
                            'display_order' => 1,
                            'created_at' => '2021-08-11 06:02:00',
                            'deleted' => false
                         ],
                         [
                            'form_id' => 2,
                            'name' => 'Location Form',
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. At risus viverra adipiscing at in tellus integer feugiat. Quis vel eros donec ac odio tempor. Mauris a diam maecenas sed enim ut sem viverra aliquet. Auctor elit sed vulputate mi sit. Vitae auctor eu augue ut lectus arcu bibendum at varius. Tempus iaculis urna id volutpat. Consectetur libero id faucibus nisl tincidunt eget nullam non. Aliquam purus sit amet luctus venenatis lectus magna fringilla urna. Id semper risus in hendrerit gravida rutrum quisque. Orci phasellus egestas tellus rutrum tellus pellentesque eu. Amet cursus sit amet dictum sit amet justo donec. Volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque. Neque laoreet suspendisse interdum consectetur libero id faucibus nisl. Lorem dolor sed viverra ipsum. Bibendum arcu vitae elementum curabitur vitae. Ullamcorper velit sed ullamcorper morbi.',
                            'template_url' => 'location_form',
                            'visibility' => true,
                            'display_order' => 2,
                            'created_at' => '2021-08-11 06:02:00',
                            'deleted' => false
                         ],
                         [
                            'form_id' => 3,
                            'name' => 'VC Form',
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. At risus viverra adipiscing at in tellus integer feugiat. Quis vel eros donec ac odio tempor. Mauris a diam maecenas sed enim ut sem viverra aliquet. Auctor elit sed vulputate mi sit. Vitae auctor eu augue ut lectus arcu bibendum at varius. Tempus iaculis urna id volutpat. Consectetur libero id faucibus nisl tincidunt eget nullam non. Aliquam purus sit amet luctus venenatis lectus magna fringilla urna. Id semper risus in hendrerit gravida rutrum quisque. Orci phasellus egestas tellus rutrum tellus pellentesque eu. Amet cursus sit amet dictum sit amet justo donec. Volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque. Neque laoreet suspendisse interdum consectetur libero id faucibus nisl. Lorem dolor sed viverra ipsum. Bibendum arcu vitae elementum curabitur vitae. Ullamcorper velit sed ullamcorper morbi.',
                            'template_url' => 'vc_form',
                            'visibility' => true,
                            'display_order' => 3,
                            'created_at' => '2021-08-11 06:02:00',
                            'deleted' => false
                        ]
                    ];

        $forms = $this->table('forms');
        $forms->insert($formData)->saveData();
    }
}
