<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use App\Models\Domain;
use App\Services\DomainCheckerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DomainController extends Controller
{
    public function __construct(protected DomainCheckerService $domainCheckerService)
    {

    }

    public function index():View
    {
        $domains = Domain::all();
        $results = $this->domainCheckerService->checkDomains($domains);
        // Return the structured results as JSON or pass them to the view
        return view('domain.index', ['results' => $results,'domains'=>$domains]);

    }
    public function indexAll():View
    {
        $domains = Domain::paginate(6);
        // Return the structured results as JSON or pass them to the view
        return view('domain.all-domains', ['domains'=>$domains]);

    }

    public function create(): View
    {
        return view('domain.create');
    }
    public function store(StoreDomainRequest $request)
    {
        Domain::create($request->validated());
        return redirect('/domains');
    }
    public function edit(Domain $domain): View
    {
        return view('domain.edit',['domain'=>$domain]);
    }
    public function update(UpdateDomainRequest $request,Domain $domain): RedirectResponse
    {

        // Validate and update the domain
        $validated = $request->validated();
        $domain->update($validated);

        // Redirect back to the domains index page
        return redirect('/domains')->with('success', 'Domain updated successfully.');
    }

    public function destroy(Domain $domain)
    {
        $domain->delete();
        return redirect()->back()->with('message', 'Domain deleted successfully!');
    }
}
