import { DemoTableBasicComponent } from './demos/basic/basic';
import { DemoTableStripedComponent } from './demos/striped/striped';
import { DemoTableHoverComponent } from './demos/hover/hover';
import { DemoTableBorderComponent } from './demos/border/border';
import { DemoTableSmallComponent } from './demos/small/small';

import { ContentSection } from '@app/shared/components/docs/models/content-section.model';
import { ExamplesComponent } from '@app/shared/components/docs/demo-section-components/demo-examples-section/index';

export const demoComponentContent: ContentSection[] = [
  {
    name: 'Examples',
    anchor: 'examples',
    outlet: ExamplesComponent,
    content: [
      {
        title: 'Basic',
        anchor: 'basic',
        description: `<p>Using the most basic table markup, here’s how <code>.table</code>-based tables look in Bootstrap.</p>`,
        html: require('!!raw-loader!./demos/basic/basic.html'),
        outlet: DemoTableBasicComponent
      },
      {
        title: 'Striped rows',
        anchor: 'striped-rows',
        description: `<p>Use <code>.table-striped</code> to add zebra-striping to any table row within the <code>&lt;tbody&gt;</code>.</p>`,
        html: require('!!raw-loader!./demos/striped/striped.html'),
        outlet: DemoTableStripedComponent
      },
      {
        title: 'Hoverable rows',
        anchor: 'hover',
        description: `<p>Add <code>.table-hover</code> to enable a hover state on table rows within a <code>&lt;tbody&gt;</code>.</p>`,
        html: require('!!raw-loader!./demos/hover/hover.html'),
        outlet: DemoTableHoverComponent
      },
      {
        title: 'Border',
        anchor: 'border',
        description: `<p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p>`,
        html: require('!!raw-loader!./demos/border/border.html'),
        outlet: DemoTableBorderComponent
      },
      {
        title: 'Small',
        anchor: 'small',
        description: `<p>Add <code>.table-sm</code> to make any <code>.table</code> more compact by cutting all cell <code>padding</code> in half.</p>`,
        html: require('!!raw-loader!./demos/small/small.html'),
        outlet: DemoTableSmallComponent
      }
    ]
  }
];
