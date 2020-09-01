<html>
<head>
    <style type="text/css">
        .studentInfo {
            width: 4000px;
            border-collapse: collapse;
        }
        .studentInfo td {
            border: 1px solid black;
            height: 90px;
            text-align: center;
            font-size: 50px;
            font-weight: bolder;
        }
        /* .studentInfo tr:nth-child(even) {
            background-color: #E4FFB7;
        }
        .studentInfo tr:nth-child(odd) {
            background-color: #EFFFD2;
        }
        */
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 50px;
            background-color: #80B327;
            color: white;
        }
    </style>
</head>
<body>
    <table class="studentInfo">
        <tbody>
        <tr class="mainRow">
            <td class="header" colspan="1">Sr.No.</td>
            <td class="header" colspan="2">User name</td>
            <td class="header" colspan="3">Name</td>
            <td class="header" colspan="7">Packages</td>
        </tr>
        
        <?php $i = 1; foreach ($this->data['data'] as $detail) { ?>
            <tr class="altrow">
                <td class="header" colspan="1"><?php echo $i; ?></td>
                <td class="header" colspan="2"><?php echo $detail['username']; ?></td>
                <td class="header" colspan="3"><?php echo $detail['name']; ?></td>
                <td class="header" colspan="7"><?php echo $detail['mapped_packages']; ?></td>
            </tr>    
        <?php $i++;  } ?>
           
        </tbody></table>
    </body>
    </html>