<?php

namespace App\Http\Controllers\ProjectManage\Appeal;

use App\Http\Controllers\Controller;
use App\ProjectManage\Models\Label;
use App\ProjectManage\Models\LabelCategory;
use App\ProjectManage\Repositories\LabelRepository;
use Illuminate\Http\Request;

class LabelsController extends Controller
{
    /**
     * @var LabelRepository
     */
    private $labels;

    /**
     * LabelsController constructor.
     * @param LabelRepository $labels
     */
    public function __construct(LabelRepository $labels)
    {
        parent::__construct();

        $this->labels = $labels;
    }

    /**
     * @param Request $request
     * @param LabelCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, LabelCategory $category)
    {
        $labels = $this->labels->getLabels($category, $request->input('is_open', 0));
        return $this->successWithData(compact('labels'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'label_category_id' => 'required|integer|exists:pm_label_categories,id',
            'name' => 'required|string',
            'is_open' => 'required|integer|in:0,1',
            'comment' => 'string|max:255',
            'sort' => 'integer',
        ]);
        $this->labels->create($validatedData);

        return $this->success();
    }

    /**
     * @param Request $request
     * @param Label $label
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Label $label)
    {
        $validatedData = $request->validate([
            'label_category_id' => 'required|integer|exists:pm_label_categories,id',
            'name' => 'required|string',
            'is_open' => 'required|integer|in:0,1',
            'comment' => 'string|max:255',
        ]);
        $this->labels->update($label, $validatedData);

        return $this->success();
    }

    /**
     * @param Label $label
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Label $label)
    {
        if ($label->appeals()->get()->isNotEmpty()) {
            return $this->failedWithMessage('该标签已关联了诉求');
        }
        $label->delete();
        return $this->success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort(Request $request)
    {
        $data = $request->validate([
            'labels_sort' => 'required|array',
            'labels_sort.*.label_id' => 'required|integer|exists:pm_labels,id',
            'labels_sort.*.sort' => 'required|integer',
        ]);
        $this->labels->sort($data['labels_sort']);

        return $this->success();
    }
}
