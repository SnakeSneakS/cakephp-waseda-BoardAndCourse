
<h2> ADMIN PAGE </h2>

<div>
    <h3>users</h3>
    <ul>
        <li> <?php echo $this->Html->Link("users",array("action"=>"user"));?>: 登録ユーザ </li>
        <li> <?php echo $this->Html->Link("usersDepartmentSelections",array("action"=>"userDepartmentSelection"));?>: ユーザの学科選択調査 </li>
    </ul>
</div>

<div>
    <h3>base</h3>
    <ul>
        <li> <?php echo $this->Html->Link("faculties",array("action"=>"faculty"));?>: 学術院 </li>
        <li> <?php echo $this->Html->Link("schools",array("action"=>"school"));?>: 学部 </li>
        <li> <?php echo $this->Html->Link("departments",array("action"=>"department"));?>: 学科 </li>
    </ul>
</div>

<div>
    <h3>relationship</h3>
    <ul>
        <li> <?php echo $this->Html->Link("FacultySchool",array("action"=>"facultySchool"));?>: 学術院と学部の関係</li>
        <li> <?php echo $this->Html->Link("SchoolDepartment",array("action"=>"schoolDepartment"));?>: 学部と学科の関係 </li>
        <li> <?php echo $this->Html->Link("AvailableDepartmentSelection",array("action"=>"availableDepartmentSelection"));?>:可能な学科選択 </li>
    </ul>
</div>



