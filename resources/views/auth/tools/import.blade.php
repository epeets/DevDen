@extends('auth.layouts.app')

@section('content')
<div class="table-responsive">
    <div class="table">
        <table class="table-striped">
            <tbody>
                <tr>
                    <td>
                        <a href="/auth/tools/import/wp"><span>Wordpress</span></a>
                    </td>
                    <td><span>Import posts from Wordpress</span></td>
                </tr>
                <tr>
                    <td><span>Magento</span></td>
                    <td><span>Connect your magento store via API</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection