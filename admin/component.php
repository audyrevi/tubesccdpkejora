<?php
// Component Interface
interface Component {
    public function render();
}

// Leaf class for Pelanggan
class Pelanggan implements Component {
    private $jumlahmember;

    public function __construct($jumlahmember) {
        $this->jumlahmember = $jumlahmember;
    }

    public function render() {
        return '<div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h3 class="box-title">Pelanggan</h3>
                        <ul class="list-inline two-part">
                            <li>
                                <div id="sparklinedash2"></div>
                            </li>
                            <li class="text-right"><i class="ti-arrow-up text-purple"></i> 
                            <span class="counter text-purple">' . htmlspecialchars($this->jumlahmember) . '</span></li>
                        </ul>
                    </div>
                </div>';
    }
}

// Leaf class for Transaksi
class Transaksi implements Component {
    private $jumlahtransaksi;

    public function __construct($jumlahtransaksi) {
        $this->jumlahtransaksi = $jumlahtransaksi;
    }

    public function render() {
        return '<div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h3 class="box-title">Transaksi</h3>
                        <ul class="list-inline two-part">
                            <li>
                                <div id="sparklinedash3"></div>
                            </li>
                            <li class="text-right"><i class="ti-arrow-up text-info"></i> 
                            <span class="counter text-info">' . htmlspecialchars($this->jumlahtransaksi) . '</span></li>
                        </ul>
                    </div>
                </div>';
    }
}

// Composite class for Dashboard
class Dashboard implements Component {
    private $components = [];

    public function add(Component $component) {
        $this->components[] = $component;
    }

    public function render() {
        $html = '<div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title">Dashboard</h4>
                        </div>
                        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                            <ol class="breadcrumb">
                                <li><a href="#">Dashboard</a></li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">';
        foreach ($this->components as $component) {
            $html .= $component->render();
        }
        $html .= '</div></div>';
        return $html;
    }
}
?>
