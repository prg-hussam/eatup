<?php

namespace Modules\User\Http\Controllers\Admin;


use Inertia\Inertia;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Customer;
use Modules\Support\Traits\HasCrudActions;
use Modules\User\Transformers\Admin\CustomerResource;
use Modules\User\Http\Requests\Admin\SaveUserRequest;

class CustomerController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Customer::class;


    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'admin.customers.customer';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $component = 'Customer';



    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveUserRequest::class;

    /**
     * Entity a resource to a controller.
     *
     * @var array|string
     */
    protected array|string $resource = CustomerResource::class;

    /**
     * Pipeline through
     *
     * @var array
     */
    protected array $pipelineThrough = [
        "index" => [
            \Modules\Support\Filters\FromCreatedAtFilter::class,
            \Modules\Support\Filters\ToCreatedAtFilter::class,
            \Modules\Support\Filters\ActiveStatusesFilter::class,
            \Modules\User\Filters\Customer\CustomerSearchFilter::class,
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected array $fillableActivityLog = [
        "attributes" => ["name"],
    ];


    /**
     * Customer show page tabs
     *
     * @var array
     */
    protected $tabs = [
        "overview" => "Overview",
    ];


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param string $tab
     * @return \Illuminate\Http\Response
     */
    public function show(int $id, string $tab = null)
    {
        if (!in_array($tab, array_keys($this->tabs))) {
            return redirect()->route('admin.customers.show', [
                'id' => $id,
                'tab' => array_key_first($this->tabs)
            ]);
        }

        switch ($tab) {
            case "overview":
                break;
        }

        $user = $this->getEntity($id);

        $data = [
            "shared" => [
                'id' => $user->id,
                "name" => $user->name,
                "create_date" => dateTimeFormat($user->created_at),
                "tab" => $tab,
                "is_active" => $user->is_active,
            ],
            ...method_exists($this, "getData{$tab}") ? $this->{"getData{$tab}"}($user) : []
        ];

        return Inertia::render("Admin/{$this->component}/Show/Tabs/{$this->tabs[$tab]}/Index", $data);
    }


    /**
     * Get index page data
     * @return array
     */
    protected function indexData(): array
    {
        return [
            'filters' => []
        ];
    }
}