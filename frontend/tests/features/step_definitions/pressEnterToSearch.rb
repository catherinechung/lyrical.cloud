And /^I have selected an artist from dropdown$/ do
    find('#automplete-1').text.should_not eq ''
end

When /^I press enter$/ do
    find('#searchButton').send_keys(:return)
end

And /^the (.*) is visible$/ do |button|
    find('#artistLabel')[:visible].should eq 'visible'
end
