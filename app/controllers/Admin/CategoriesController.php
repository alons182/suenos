<?php namespace app\controllers\Admin;

use Illuminate\Support\Facades\Input;
use Laracasts\Flash\Flash;
use Suenos\Categories\CategoryRepository;
use Suenos\Forms\CategoryForm;
use Baum\MoveNotPossibleException as moveExp;

class CategoriesController extends \BaseController {

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var CategoryForm
     */
    private $categoryForm;

    function __construct(CategoryRepository $categoryRepository, CategoryForm $categoryForm)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryForm = $categoryForm;
        $this->beforeFilter('role:administrator');
    }


    /**
     * Display a listing of the resource.
     * GET /categories
     *
     * @return Response
     */
    public function index()
    {
        $search = Input::all();
        $search['q'] = (isset($search['q'])) ? trim($search['q']) : '';
        $search['published'] = (isset($search['published'])) ? $search['published'] : '';
        $categories = $this->categoryRepository->getAll($search);

        return \View::make('admin.categories.index')->with([
            'categories'     => $categories,
            'search'         => $search['q'],
            'selectedStatus' => $search['published']

        ]);
    }

    /**
     * Show the form for creating a new resource.
     * GET /categories/create
     *
     * @return Response
     */
    public function create()
    {
        $options = $this->categoryRepository->getParents();

        return \View::make('admin.categories.create')->withOptions($options);
    }

    /**
     * Store a newly created resource in storage.
     * POST /categories
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $this->categoryForm->validate($input);
        $this->categoryRepository->store($input);

        Flash::message('Category created');

        return \Redirect::route('categories');
    }

    /**
     * Show the form for editing the specified resource.
     * GET /categories/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findById($id);
        $options = $this->categoryRepository->getParents();

        return \View::make('admin.categories.edit')->withCategory($category)->withOptions($options);
    }

    /**
     * Update the specified resource in storage.
     * PUT /categories/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();
        $this->categoryForm->validate($input);
        $this->categoryRepository->update($id, $input);

        Flash::message('Category updated');

        return \Redirect::route('categories');
    }


    /**
     * Remove the specified resource from storage.
     * DELETE /categories/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->categoryRepository->destroy($id);

        Flash::message('Category Deleted');

        return \Redirect::route('categories');
    }


    /**
     * Featured.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function feat($id)
    {
        $this->categoryRepository->update_feat($id, 1);

        return \Redirect::route('categories');
    }

    /**
     * un-featured.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function unfeat($id)
    {
        $this->categoryRepository->update_feat($id, 0);

        return \Redirect::route('categories');
    }


    /**
     * published.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function pub($id)
    {
        $this->categoryRepository->update_state($id, 1);

        return \Redirect::route('categories');
    }

    /**
     * Unpublished.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function unpub($id)
    {
        $this->categoryRepository->update_state($id, 0);

        return \Redirect::route('categories');
    }


    /**
     * Move the specified page up.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function up($id)
    {
        return $this->move($id, 'before');
    }

    /**
     * Move the specified page down.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function down($id)
    {
        return $this->move($id, 'after');
    }

    /**
     * Move the page.
     *
     * @param  int $id
     * @param  'before'|'after' $dir
     *
     * @return Response
     */
    protected function move($id, $dir)
    {
        $category = $this->categoryRepository->findById($id);
        $response = \Redirect::route('categories');

        if (! $category->isRoot())
        {
            try
            {
                ($dir === 'before') ? $category->moveLeft() : $category->moveRight();
                Flash::message('Category moved');

                return $response;

            } catch (moveExp $ex)
            {
                Flash::warning('The category did not move');

                return $response;
            }


        }
        Flash::warning('The category did not move');

        return $response;
    }

}