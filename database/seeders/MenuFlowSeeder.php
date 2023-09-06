<?php

namespace Database\Seeders;

use App\Models\Setting\Globals\Menu;
use App\Models\Setting\Globals\MenuFlow;
use Illuminate\Database\Seeder;

class MenuFlowSeeder extends Seeder
{
    public function run()
    {
        $data = [
            
            // [
            //     'module'    => 'incident',
            //     'submenu'   => [
            //         [
            //             'module'   => 'incident.report',
            //             'FLOWS'     => [
            //                 // [
            //                 //     'role_id'   => 6,
            //                 //     'type'      => 1,
            //                 // ],
            //                 [
            //                     'role_id'   => 7,
            //                     'type'      => 1,
            //                 ]
            //             ]
            //         ],
            //         [
            //             'module'   => 'incident.identification',
            //             'FLOWS'     => [
            //                 // [
            //                 //     'role_id'   => 6,
            //                 //     'type'      => 1,
            //                 // ],
            //                 [
            //                     'role_id'   => 7,
            //                     'type'      => 1,
            //                 ]
            //             ]
            //         ],
            //         [
            //             'module'   => 'incident.withdrawal',
            //             'FLOWS'     => [
            //                 // [
            //                 //     'role_id'   => 6,
            //                 //     'type'      => 1,
            //                 // ],
            //                 [
            //                     'role_id'   => 7,
            //                     'type'      => 1,
            //                 ]
            //             ]
            //         ],
            //         [
            //             'module'   => 'incident.repair',
            //             'FLOWS'     => [
            //                 // [
            //                 //     'role_id'   => 6,
            //                 //     'type'      => 1,
            //                 // ],
            //                 [
            //                     'role_id'   => 7,
            //                     'type'      => 1,
            //                 ]
            //             ]
            //         ],
            //     ]
            // ],
            // PURCHASING
            [
                'module'   => 'asuransi',
                'submenu'=> [
                    [
                        'module'   => 'asuransi.polis-mobil',
                    ],
                ]
            ],
            // [
            //     'module'    => 'change',
            //     'submenu'   => [
            //         [
            //             'module'   => 'change.request',
            //             'FLOWS'     => [
            //                 // [
            //                 //     'role_id'   => 6,
            //                 //     'type'      => 1,
            //                 // ],
            //                 [
            //                     'role_id'   => 7,
            //                     'type'      => 1,
            //                 ]
            //             ]
            //         ],
            //         [
            //             'module'   => 'change.analysis',
            //             'FLOWS'     => [
            //                 // [
            //                 //     'role_id'   => 6,
            //                 //     'type'      => 1,
            //                 // ],
            //                 [
            //                     'role_id'   => 7,
            //                     'type'      => 1,
            //                 ]
            //             ]
            //         ],
            //         [
            //             'module'   => 'change.settlement',
            //             'FLOWS'     => [
            //                 // [
            //                 //     'role_id'   => 6,
            //                 //     'type'      => 1,
            //                 // ],
            //                 [
            //                     'role_id'   => 7,
            //                     'type'      => 1,
            //                 ]
            //             ]
            //         ],
            //     ]
            // ],
            // [
            //     'module'   => 'knowledge',
            //     'FLOWS'     => [
            //         // [
            //         //     'role_id'   => 6,
            //         //     'type'      => 1,
            //         // ],
            //         [
            //             'role_id'   => 7,
            //             'type'      => 1,
            //         ]
            //     ]
            // ],
        ];

        $this->generate($data);
    }

    public function generate($data)
    {
        ini_set("memory_limit", -1);
        $exists = [];
        $order = 1;
        foreach ($data as $row) {
            // $this->command->getOutput()->progressAdvance();
            $menu = Menu::firstOrNew(['module' => $row['module']]);
            $menu->order = $order;
            $menu->save();
            $exists[] = $menu->id;
            $order++;
            if (!empty($row['submenu'])) {
                foreach ($row['submenu'] as $val) {
                    // $this->command->getOutput()->progressAdvance();
                    $submenu = $menu->child()->firstOrNew(['module' => $val['module']]);
                    $submenu->order = $order;
                    $submenu->save();
                    $exists[] = $submenu->id;
                    $order++;
                }
            }
        }
        Menu::whereNotIn('id', $exists)->delete();
    }

    public function countActions($data)
    {
        $count = 0;
        foreach ($data as $row) {
            $count++;
            if (!empty($row['submenu'])) {
                $count += count($row['submenu']);
            }
        }
        return $count;
    }
}
