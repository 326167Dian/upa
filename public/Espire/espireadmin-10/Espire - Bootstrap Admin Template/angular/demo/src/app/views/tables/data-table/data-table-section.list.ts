import { DemoDataTableBasicComponent } from'./demos/basic/basic'; 
import { DemoDataTableFilterComponent } from './demos/filter/filter';
import { DemoDataTableFooterComponent } from './demos/footer/footer';
import { DemoDataTableTreeComponent }from './demos/tree/tree';
import { DemoDataTableRowDetailComponent } from './demos/row-detail/row-detail';
import { DemoDataTableVirtualComponent } from './demos/virtual/virtual';
import { DemoDataTableSortingComponent } from './demos/sorting/sorting';
import { DemoDataTableCellSelectComponent } from './demos/cell-select/cell-select';
import { DemoDataTableCheckboxSelectComponent } from './demos/checkbox-select/checkbox-select';
import { DemoDataTableInlineComponent } from './demos/inline/inline';
import { DemoDataTableColumnToggleComponent } from './demos/column-toggle/column-toggle';
import { DemoDataTableColumnPinningComponent } from './demos/column-pinning/column-pinning';

import { ContentSection } from '@app/shared/components/docs/models/content-section.model';
import { DemoTopSectionComponent } from '@app/shared/components/docs/demo-section-components/demo-top-section/index';
import { ExamplesComponent } from '@app/shared/components/docs/demo-section-components/demo-examples-section/index';
import { ApiSectionsComponent } from '@app/shared/components/docs/demo-section-components/demo-api-section/index';

import {
  NgApiDocComponent
} from '@app/shared/components/docs/api-docs';

export const demoComponentContent: ContentSection[] = [
  {
    name: 'Usage',
    anchor: 'usage',
    outlet: DemoTopSectionComponent,
    content: {
      doc: require('!!raw-loader!./docs/usage.md')
    }
  },
  {
    name: 'Examples',
    anchor: 'examples',
    outlet: ExamplesComponent,
    content: [
      {
        title: 'Basic',
        anchor: 'basic',
        description: `<p>Basic usage of data table</p>`,
        component: require('!!raw-loader!./demos/basic/basic'),
        html: require('!!raw-loader!./demos/basic/basic.html'),
        outlet: DemoDataTableBasicComponent
      },
      {
        title: 'Filter',
        anchor: 'filter',
        description: `<p>Client-side Search and Filtering</p>`,
        component: require('!!raw-loader!./demos/filter/filter'),
        html: require('!!raw-loader!./demos/filter/filter.html'),
        svc: require('!!raw-loader!./demos/filter/data.service'),
        outlet: DemoDataTableFilterComponent
      },
      {
        title: 'Footer',
        anchor: 'footer',
        description: `<p>Custom Footer</p>`,
        component: require('!!raw-loader!./demos/footer/footer'),
        html: require('!!raw-loader!./demos/footer/footer.html'),
        outlet: DemoDataTableFooterComponent
      },
      {
        title: 'Tree',
        anchor: 'tree',
        description: `<p>Flex Column Width Distribution</p>`,
        component: require('!!raw-loader!./demos/tree/tree'),
        html: require('!!raw-loader!./demos/tree/tree.html'),
        svc: require('!!raw-loader!./demos/tree/data.service'),
        outlet: DemoDataTableTreeComponent
      },
      {
        title: 'Row Details',
        anchor: 'row-detail',
        description: `<p>Row Detail</p>`,
        component: require('!!raw-loader!./demos/row-detail/row-detail'),
        html: require('!!raw-loader!./demos/row-detail/row-detail.html'),
        svc: require('!!raw-loader!./demos/row-detail/data.service'),
        outlet: DemoDataTableRowDetailComponent
      },
      {
        title: 'Virtual Scrolling',
        anchor: 'virtual-scrolling',
        description: `<p>Virtual Server-side Paging</p>`,
        component: require('!!raw-loader!./demos/virtual/virtual'),
        html: require('!!raw-loader!./demos/virtual/virtual.html'),
        svc: require('!!raw-loader!./demos/virtual/data.service'),
        outlet: DemoDataTableVirtualComponent
      },
      {
        title: 'Sorting',
        anchor: 'sorting',
        description: `<p>Client-side Sorting</p>`,
        component: require('!!raw-loader!./demos/sorting/sorting'),
        html: require('!!raw-loader!./demos/sorting/sorting.html'),
        outlet: DemoDataTableSortingComponent
      },
      {
        title: 'Cell Selection',
        anchor: 'cell-selection',
        description: `<p>Cell Selection</p>`,
        component: require('!!raw-loader!./demos/cell-select/cell-select'),
        html: require('!!raw-loader!./demos/cell-select/cell-select.html'),
        outlet: DemoDataTableCellSelectComponent
      },
      {
        title: 'Checkbox Selection',
        anchor: 'checkbox-selection',
        description: `<p>Checkbox Selection</p>`,
        component: require('!!raw-loader!./demos/checkbox-select/checkbox-select'),
        html: require('!!raw-loader!./demos/checkbox-select/checkbox-select.html'),
        outlet: DemoDataTableCheckboxSelectComponent
      },
      {
        title: 'Inline',
        anchor: 'inline',
        description: `<p>Expressive Templates</p>`,
        component: require('!!raw-loader!./demos/inline/inline'),
        html: require('!!raw-loader!./demos/inline/inline.html'),
        outlet: DemoDataTableInlineComponent
      },
      {
        title: 'Toggling',
        anchor: 'toggling',
        description: `<p>Column Toggling</p>`,
        component: require('!!raw-loader!./demos/column-toggle/column-toggle'),
        html: require('!!raw-loader!./demos/column-toggle/column-toggle.html'),
        outlet: DemoDataTableColumnToggleComponent
      },
      {
        title: 'Column Pinning',
        anchor: 'column-pinning',
        description: `<p>Column Pinning</p>`,
        component: require('!!raw-loader!./demos/column-pinning/column-pinning'),
        html: require('!!raw-loader!./demos/column-pinning/column-pinning.html'),
        svc: require('!!raw-loader!./demos/column-pinning/data.service'),
        outlet: DemoDataTableColumnPinningComponent
      },
    ]
  },
  {
    name: 'API Reference',
    anchor: 'api-reference',
    outlet: ApiSectionsComponent,
    content: [
      {
        title: 'DataTableComponent',
        anchor: 'DataTableComponent',
        outlet: NgApiDocComponent
      },
      {
        title: 'DataTableColumnDirective',
        anchor: 'DataTableColumnDirective',
        outlet: NgApiDocComponent
      },
      {
        title: 'DatatableRowDetailDirective',
        anchor: 'DatatableRowDetailDirective',
        outlet: NgApiDocComponent
      }
    ]
  }
];
