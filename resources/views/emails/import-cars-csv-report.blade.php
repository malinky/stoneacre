<p>Cars Imported: {{ $report->getImported() }}</p>
<p>Failed Car Imports: {{ count($report->getFailed()) }}</p>
@if ($report->getFailed())
<table>
  @foreach ($report->getFailed() as $failed)
  <tr>
    <td>Line Number: {{ $failed[0] }}</td>
    <td>Error: {{ $failed[1] }}</td>
  </tr>
  @endforeach
</table>
@endif
